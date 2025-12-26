<?php
define('WRITEPATH', __DIR__.'/../writable/uploads/');
define('STATUSPATH', WRITEPATH.'compress_status/');
$queueFile = WRITEPATH . "compress_queue.json";
$logFile   = '/var/log/compress_worker_error.log';

if(!is_dir(STATUSPATH)) mkdir(STATUSPATH, 0777, true);

function getVideoDuration($file){
    if(!file_exists($file)) return 1;
    $cmd = "/usr/bin/ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($file);
    $duration = trim(shell_exec($cmd));
    return floatval($duration) ?: 1;
}

function logError($msg){
    global $logFile;
    file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] ".$msg.PHP_EOL, FILE_APPEND);
}

while(true){
    if(!file_exists($queueFile)){
        sleep(3);
        continue;
    }

    $queue = json_decode(file_get_contents($queueFile), true);
    if(empty($queue)){
        sleep(3);
        continue;
    }

    foreach($queue as $idx => $item){
        $src  = $item['path'];
        $file = $item['file'];
        $tmp  = $src . ".tmp.mp4";
        $statusFile = STATUSPATH . $file . ".json";

        if(!file_exists($src)){
            file_put_contents($statusFile, json_encode(['status'=>'error','progress'=>0,'message'=>'file not found']));
            unset($queue[$idx]);
            file_put_contents($queueFile, json_encode(array_values($queue)));
            continue;
        }

        file_put_contents($statusFile, json_encode(['status'=>'compressing','progress'=>0]));
        $duration = getVideoDuration($src);

        $cmd = "/usr/bin/ffmpeg -i " . escapeshellarg($src) . 
        " -vf scale=1280:-2" .    
        " -c:v libx264 -crf 25 -preset medium" . 
        " -an" .                     
        " -y " . escapeshellarg($tmp) .
        " -progress pipe:1 -nostats"; 
        
        $proc = proc_open($cmd, $descriptors, $pipes);
        if(!is_resource($proc) || !isset($pipes[1])){
            file_put_contents($statusFile, json_encode(['status'=>'error','progress'=>0,'message'=>'proc_open failed']));
            logError("proc_open failed for $src");
            unset($queue[$idx]);
            file_put_contents($queueFile, json_encode(array_values($queue)));
            continue;
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $done = false;
        while(!$done){
            $stdout = fgets($pipes[1]);
            $stderr = fgets($pipes[2]);

            if($stdout !== false && strpos($stdout,'out_time_ms=')===0){
                $ms   = intval(substr($stdout,12));
                $sec  = $ms / 1000000;
                $perc = min(100, round($sec/$duration*100));
                file_put_contents($statusFile, json_encode(['status'=>'compressing','progress'=>$perc]));
            }

            if($stderr !== false && !empty($stderr)){
                logError("FFmpeg error ($file): ".$stderr);
            }

            $status = proc_get_status($proc);
            if(!$status['running']) $done = true;

            usleep(10000);
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($proc);

        if(file_exists($tmp)){
            rename($tmp,$src);
            file_put_contents($statusFile, json_encode(['status'=>'done','progress'=>100]));
        } else {
            file_put_contents($statusFile, json_encode(['status'=>'error','progress'=>0,'message'=>'tmp file not created']));
            logError("Compression failed for $file");
        }

        unset($queue[$idx]);
        file_put_contents($queueFile, json_encode(array_values($queue)));
    }

    usleep(500000); 
}
