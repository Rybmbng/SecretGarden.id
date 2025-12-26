<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;
use App\Models\CompanySettingModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\NotificationModel;
use App\Models\FooterLinkModel;
use App\Models\NotificationSettingModel;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['menu','menupublic'];
    protected $companySetting;
    protected $footerLinks;
    protected $defaultPath;
    protected $notifications = [];
    protected $notifSounds = []; 

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load models
        $companyModel = new CompanySettingModel();
        $footerModel  = new FooterLinkModel();
        $productModel = new ProductModel();
        $variantModel = new ProductVariantModel();
        $notificationModel = new NotificationModel();
        $settingModel = new NotificationSettingModel();

        // Company & footer
        $this->companySetting = $companyModel->first() ?? [
            'name' => 'SecretGarden',
            'logo' => 'assets/SGV/footer/footer.jpg',
            'favicon' => 'assets/SGV/sg.png',
            'tagline' => 'Inspired by Earth, Made For You',
        ];
        $this->footerLinks = $footerModel->orderBy('position','ASC')->findAll();

        $notifSettings = $settingModel->findAll();
        foreach($notifSettings as $s) {
            $this->notifSounds[$s['type']] = $s['sound_file'] 
                ? base_url($s['sound_file']) 
                : base_url('assets/sounds/notif.mp3');
        }

        // Generate notifikasi otomatis
        $this->generateNotification($productModel, $variantModel, $notificationModel, $settingModel);

        // Ambil notifikasi terbaru untuk header
        $this->notifications = $notificationModel
            ->where('is_read',0)
            ->orderBy('created_at','DESC')
            ->limit(5)
            ->findAll();

        // Share ke semua view
        $renderer = Services::renderer();
        $renderer->setVar('companySetting', $this->companySetting);
        $renderer->setVar('footerLinks', $this->footerLinks);
        $renderer->setVar('notifications', $this->notifications);
        $renderer->setVar('notifSounds', $this->notifSounds);

        $this->defaultPath = [
            'images' => 'uploads/images/',
            'docs'   => 'uploads/documents/',
            'items'  => 'uploads/SG/',
            'assets' => 'assets/'
        ];
    }

    protected function generateNotification($productModel, $variantModel, $notificationModel, $settingModel)
    {
        $rules = $settingModel->where('is_enabled',1)->findAll();

        foreach ($rules as $rule) {
            // Tentukan model class
            $modelClass = "App\\Models\\".$rule['model']."Model";
            if(!class_exists($modelClass)) continue;

            $model = new $modelClass();
            $query = $model;

            if(!empty($rule['condition'])){
                $query = $query->where($rule['condition'], null, false);
            }

            $limit = (int)($rule['limit'] ?? 5);
            $items = $query->orderBy('created_at','DESC')->limit($limit)->findAll();

            foreach($items as $item){
                $msg = $rule['message_template'];

                foreach($item as $k=>$v){
                    $msg = str_replace('{'.$k.'}', $v, $msg);
                }

                if(isset($item['product_id'])){
                    $product = $productModel->find($item['product_id']);
                    $msg = str_replace('{product_name}', $product['name'] ?? '', $msg);
                }

                if($rule['model']=='ProductVariant'){
                    $msg = str_replace('{variant_name}', $item['name'] ?? '', $msg);
                }

                if(isset($item['stock']) && strpos($msg,'{field}')!==false){
                    $msg = str_replace('{field}', $item['stock'], $msg);
                }

                if($rule['type']=='product_edited'){
                    $old = $item['prev_name'] ?? $item['name']; 
                    $new = $item['name'];
                    $msg = str_replace('{old_value}', $old, $msg);
                    $msg = str_replace('{new_value}', $new, $msg);
                }

                $this->insertNotifIfEnabled($rule['type'],$msg,$notificationModel,$settingModel);
            }
        }
    }



    protected function insertNotifIfEnabled($type, $message, $notificationModel, $settingModel)
    {
        $setting = $settingModel->where('type',$type)->first();
        if(!$setting || !$setting['is_enabled']) return;

        // Cek duplikat hanya per hari
        $today = date('Y-m-d');
        $exists = $notificationModel
            ->where('type', $type)
            ->where('message', $message)
            ->where('DATE(created_at)', $today)
            ->first();

        if(!$exists){
            $notificationModel->insert([
                'type' => $type,
                'message' => $message,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            log_message('debug', "Notif generated: type=$type, message=$message");
        }
    }

    protected $user = [];
    public function ceksesi(){
        $user = session()->get('user');
        if (!isset($user['role_id']) || $user['role_id'] == 2)
        {
            return view('errors/html/error_403', [
                'pageTitle' => 'Unauthorized',
            ]);
        }
    }
}
