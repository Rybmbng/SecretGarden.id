<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use App\Models\VisitorModel;
use CodeIgniter\Files\File;


class HomeAdminController extends BaseController
{
    protected $sliderModel;
    protected $uploadPath;
    const CHUNK_SIZE = 5*1024*1024;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->uploadPath = FCPATH.'assets/SGV/Page/Home/';
        helper(['filesystem']);
        if(!is_dir($this->uploadPath)) mkdir($this->uploadPath,0777,true);
    }

    // ================= Home Dashboard =================
    public function index()
    {
        $visitorModel = new VisitorModel();
        $fromDate = $this->request->getGet('from_date') ?? date('Y-m-d', strtotime('-7 days'));
        $toDate   = $this->request->getGet('to_date') ?? date('Y-m-d');

        $todayCount = $visitorModel->where('DATE(created_at)', date('Y-m-d'))->groupBy('ip_address')->countAllResults();
        $totalVisitors = $visitorModel->groupBy('ip_address')->countAllResults();

        $last7 = $visitorModel
                    ->select("DATE(created_at) as date, COUNT(DISTINCT ip_address) as count")
                    ->groupBy('DATE(created_at)')
                    ->orderBy('date','DESC')
                    ->limit(7)
                    ->findAll();
        $chartData = array_reverse($last7);

        $popularPages = $visitorModel
                            ->select("page, COUNT(DISTINCT ip_address) as views")
                            ->groupBy('page')
                            ->orderBy('views','DESC')
                            ->limit(10)
                            ->findAll();

        $ipPages = $visitorModel
                        ->select("ip_address, page, COUNT(page) as views")
                        ->where("DATE(created_at) BETWEEN '{$fromDate}' AND '{$toDate}'")
                        ->groupBy(['ip_address','page'])
                        ->orderBy('ip_address','ASC')
                        ->orderBy('views','DESC')
                        ->findAll();

        $visitors = $visitorModel
                        ->select("ip_address, COUNT(ip_address) as views, location")
                        ->where("DATE(created_at) BETWEEN '{$fromDate}' AND '{$toDate}'")
                        ->groupBy('ip_address')
                        ->orderBy('views','DESC')
                        ->findAll();

        foreach ($visitors as &$v) {
            if (empty($v['location'])) {
                $ip = $v['ip_address'];
                $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,isp");
                $data = json_decode($json,true);
                if($data && $data['status']==='success'){
                    $v['location'] = "{$data['country']} - {$data['city']} ({$data['isp']})";
                    $visitorModel->where('ip_address',$ip)->set('location',$v['location'])->update();
                } else {
                    $v['location']='Unknown';
                }
            }
        }

        return view('admin/index', [
            'pageTitle'=>'Home',
            'todayCount'=>$todayCount,
            'totalVisitors'=>$totalVisitors,
            'chartData'=>$chartData,
            'popularPages'=>$popularPages,
            'ipPages'=>$ipPages,
            'visitors'=>$visitors,
            'fromDate'=>$fromDate,
            'toDate'=>$toDate
        ]);
    }

    // ================= Slider Management =================
    public function slider()
    {
        $slider = $this->sliderModel->findAll();
        return view('admin/page/home/index', [
            'pageTitle'=>'Management Dashboard',
            'slider'=>$slider
        ]);
    }

    public function createSlider()
    {
        // safe create view, no $slider
        return view('admin/page/home/slider/create', ['slider'=>null]);
    }

    public function editSlider($id)
    {
        $slider = $this->sliderModel->find($id);
        if(!$slider){
            return redirect()->to('/admin/page/home/slider')->with('error','Slider tidak ditemukan');
        }
        return view('admin/page/home/slider/edit',['slider'=>$slider]);
    }

    public function deleteSlider($id)
    {
        $slider = $this->sliderModel->find($id);
        if($slider){
            if(!empty($slider['srcD']) && is_file(FCPATH.$slider['srcD'])) unlink(FCPATH.$slider['srcD']);
            if(!empty($slider['srcM']) && is_file(FCPATH.$slider['srcM'])) unlink(FCPATH.$slider['srcM']);
            $this->sliderModel->delete($id);
        }
        return redirect()->to('/admin/page/home/slider')->with('success','Slider berhasil dihapus');
    }

    public function updateSlider($id)
    {
        $slider = $this->sliderModel->find($id);
        if(!$slider){
            return redirect()->to('/admin/page/home/slider')->with('error','Slider tidak ditemukan');
        }

        $data = [
            'alt'=>$this->request->getPost('alt'),
            'duration'=>$this->request->getPost('duration'),
            'status'=>$this->request->getPost('status'),
        ];

        // === File Desktop ===
        $fileD = $this->request->getFile('fileD');
        if($fileD && $fileD->isValid() && !$fileD->hasMoved()){
            $ext  = strtolower($fileD->getExtension());
            $type = in_array($ext,['mp4','webm','ogg'])?'video':'image';
            $newName = $fileD->getRandomName();
            $fileD->move($this->uploadPath,$newName);
            $data['srcD']='assets/SGV/Page/Home/'.$newName;
            $data['type']=$type;
            if(!empty($slider['srcD']) && is_file(FCPATH.$slider['srcD'])) unlink(FCPATH.$slider['srcD']);
        }

        // === File Mobile ===
        $fileM = $this->request->getFile('fileM');
        if($fileM && $fileM->isValid() && !$fileM->hasMoved()){
            $ext  = strtolower($fileM->getExtension());
            $type = in_array($ext,['mp4','webm','ogg'])?'video':'image';
            $newName = $fileM->getRandomName();
            $fileM->move($this->uploadPath,$newName);
            $data['srcM']='assets/SGV/Page/Home/'.$newName;
            $data['type']=$type;
            if(!empty($slider['srcM']) && is_file(FCPATH.$slider['srcM'])) unlink(FCPATH.$slider['srcM']);
        }

        $this->sliderModel->update($id,$data);
        return redirect()->to("/admin/page/home/slider/edit/$id")->with('success','Slider berhasil diupdate');
    }
 public function uploadChunk()
    {
        $chunk = $this->request->getFile('chunk');
        $target = $this->request->getPost('target');
        $fileName = $this->request->getPost('fileName');
        $chunkIndex = $this->request->getPost('chunkIndex');

        if(!$chunk || !$chunk->isValid()) return $this->response->setStatusCode(400)->setJSON(['error'=>'Invalid file']);

        $tempDir = $this->uploadPath.'temp/'.$fileName.'/';
        if(!is_dir($tempDir)) mkdir($tempDir,0755,true);

        $chunk->move($tempDir, $chunkIndex);
        return $this->response->setJSON(['status'=>'ok']);
    }

    // Finalize upload
    public function finalizeUpload()
    {
        $data = $this->request->getJSON(true);
        $desktop = $data['desktop'];
        $mobile = $data['mobile'];
        $alt = $data['alt'];
        $duration = $data['duration'];

        $files = ['desktop'=>$desktop,'mobile'=>$mobile];
        $finalFiles = [];

        foreach($files as $type=>$name){
            $tempDir = $this->uploadPath.'temp/'.$name.'/';
            if(!is_dir($tempDir)) continue;

            $chunks = scandir($tempDir);
            sort($chunks);
            $finalPath = $this->uploadPath.$name;
            $fp = fopen($finalPath,'w');

            foreach($chunks as $chunk){
                if(in_array($chunk,['.','..'])) continue;
                $fpChunk = fopen($tempDir.$chunk,'r');
                fwrite($fp, fread($fpChunk, filesize($tempDir.$chunk)));
                fclose($fpChunk);
            }
            fclose($fp);
            rrmdir($tempDir); // hapus folder temp
            $finalFiles[$type] = $name;

            // Masukkan ke compress queue
            $queueFile = WRITEPATH."uploads/compress_queue.json";
            $queue = file_exists($queueFile)?json_decode(file_get_contents($queueFile),true):[];
            $queue[] = ['path'=>$finalPath,'type'=>$type,'file'=>$name];
            file_put_contents($queueFile,json_encode($queue));
        }

        // Simpan DB
        $db = \Config\Database::connect();
        $db->table('slider')->insert([
            'srcD'=>$finalFiles['desktop'] ?? null,
            'srcM'=>$finalFiles['mobile'] ?? null,
            'alt'=>$alt,
            'duration'=>$duration,
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status'=>'ok','files'=>$finalFiles]);
    }

    // Poll compress status
    public function pollCompress($type,$file)
    {
        $status = cache()->get("compress_status_{$type}_$file") ?? 'pending';
        return $this->response->setJSON(['status'=>$status]);
    }

    // Compress queue (jalankan via cron tiap 30 detik)
    public function processCompressQueue()
    {
        $queueFile = WRITEPATH."uploads/compress_queue.json";
        if(!file_exists($queueFile)) return;

        $queue = json_decode(file_get_contents($queueFile), true);
        $newQueue = [];

        foreach($queue as $item){
            $filePath = $item['path'];
            $type     = $item['type'];
            $fileName = $item['file'];

            if(!file_exists($filePath)) continue;

            cache()->save("compress_status_{$type}_$fileName",'processing',3600);

            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            $compressedPath = $this->uploadPath."compressed_$fileName";

            // compress video
            if(in_array($ext,['mp4','webm','ogg'])){
                $cmd = "ffmpeg -i ".escapeshellarg($filePath)." -vcodec libx264 -crf 28 -preset fast ".escapeshellarg($compressedPath)." -y";
                exec($cmd,$output,$ret);
            } else { 
                // compress image
                $image = \Config\Services::image()
                            ->withFile($filePath)
                            ->resize(0,1080,true)
                            ->save($compressedPath,75);
            }

            if(file_exists($compressedPath)){
                rename($compressedPath, $filePath);
                cache()->save("compress_status_{$type}_$fileName",'done',3600);
            } else {
                cache()->save("compress_status_{$type}_$fileName",'error',3600);
                $newQueue[] = $item; // retry later
            }
        }

        file_put_contents($queueFile,json_encode($newQueue));
    }
}

// helper hapus folder temp
function rrmdir($dir) {
    if(is_dir($dir)){
        $objects = scandir($dir);
        foreach($objects as $object){
            if($object!="." && $object!=".."){
                if(is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                else
                    unlink($dir. DIRECTORY_SEPARATOR .$object);
            }
        }
        rmdir($dir);
    }
}
