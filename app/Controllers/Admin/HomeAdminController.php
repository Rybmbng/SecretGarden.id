<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use App\Models\VisitorModel;


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
        helper('file');

    }
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
        return view('admin/page/home/slider/create');
    }

    public function uploadChunk()
    {
        $chunk = $this->request->getFile('chunk');
        $fileName = $this->request->getPost('fileName');
        $chunkIndex = $this->request->getPost('chunkIndex');

        if (!$chunk || !$chunk->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error'=>'Invalid file']);
        }

        $tempDir = $this->uploadPath.'temp/'.$fileName.'/';
        if (!is_dir($tempDir)) mkdir($tempDir,0755,true);

        $chunk->move($tempDir, $chunkIndex);
        return $this->response->setJSON(['status'=>'ok']);
    }

    public function finalizeUpload()
{
    $data    = $this->request->getJSON(true);
    $desktop = $data['desktop'];
    $mobile  = $data['mobile'];
    $alt     = $data['alt'];
    $duration= $data['duration'];

    $files = ['desktop'=>$desktop,'mobile'=>$mobile];
    $finalFiles = [];

    foreach ($files as $type=>$name) {
        $tempDir = $this->uploadPath.'temp/'.$name.'/';
        if (!is_dir($tempDir)) continue;

        $chunks = scandir($tempDir);
        sort($chunks);

        $ext       = pathinfo($name, PATHINFO_EXTENSION);
        $finalName = 'slider_'.time().'_'.$type.'.'.$ext;
        $finalPath = $this->uploadPath.$finalName;

        $fp = fopen($finalPath,'w');
        foreach ($chunks as $chunk) {
            if (in_array($chunk, ['.','..'])) continue;
            $fpChunk = fopen($tempDir.$chunk,'r');
            fwrite($fp, fread($fpChunk, filesize($tempDir.$chunk)));
            fclose($fpChunk);
        }
        fclose($fp);

        rrmdir($tempDir);

        $finalFiles[$type] = $finalName;

        $queueFile = WRITEPATH."uploads/compress_queue.json";
        $queue = file_exists($queueFile) ? json_decode(file_get_contents($queueFile), true) : [];
        $queue[] = ['path'=>$finalPath,'type'=>$type,'file'=>$finalName];
        file_put_contents($queueFile, json_encode($queue));

        $statusDir = WRITEPATH."uploads/compress_status/";
        if (!is_dir($statusDir)) mkdir($statusDir, 0777, true);
        $statusFile = $statusDir . $finalName . ".json";
        file_put_contents($statusFile, json_encode(['status'=>'pending','progress'=>0]));
    }

    $this->sliderModel->insert([
        'srcD'       => $finalFiles['desktop'] ?? null,
        'srcM'       => $finalFiles['mobile'] ?? null,
        'alt'        => $alt,
        'duration'   => $duration,
        'created_at' => date('Y-m-d H:i:s'),
        'status' => '1',
    ]);

    return $this->response->setJSON(['status'=>'ok','files'=>$finalFiles]);
}

public function pollCompress($type, $file){
    $file = urldecode($file);
    $statusFile = WRITEPATH."uploads/compress_status/{$file}.json";

    if (file_exists($statusFile)) {
        $data = json_decode(file_get_contents($statusFile), true);
    } else {
        $data = ['status'=>'pending','progress'=>0];
    }

    return $this->response->setJSON($data);
}

// helper hapus folder
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir."/".$object))
                    $this->rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}


}
