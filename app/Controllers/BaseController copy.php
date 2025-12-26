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
    protected $helpers = ['menu'];
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

        // Load semua setting notifikasi (sound_file)
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
        // Produk baru
        $newProducts = $productModel->orderBy('created_at','DESC')->limit(3)->findAll();
        foreach($newProducts as $p){
            $this->insertNotifIfEnabled('product_added', "Produk baru ditambahkan: ".$p['name'], $notificationModel, $settingModel);
        }

        // Produk diperbarui
        $editedProducts = $productModel->where('updated_at > created_at')->orderBy('updated_at','DESC')->limit(3)->findAll();
        foreach($editedProducts as $p){
            $this->insertNotifIfEnabled('product_edited', "Produk diperbarui: ".$p['name'], $notificationModel, $settingModel);
        }

        // Variant baru
        $newVariants = $variantModel->orderBy('created_at','DESC')->limit(3)->findAll();
        foreach($newVariants as $v){
            $product = $productModel->find($v['product_id']);
            $this->insertNotifIfEnabled('variant_added', "Variant baru untuk produk ".$product['name'].": ".$v['name'], $notificationModel, $settingModel);
        }

        // Variant diperbarui
        $editedVariants = $variantModel->where('updated_at > created_at')->orderBy('updated_at','DESC')->limit(3)->findAll();
        foreach($editedVariants as $v){
            $product = $productModel->find($v['product_id']);
            $this->insertNotifIfEnabled('variant_edited', "Variant diperbarui untuk produk ".$product['name'].": ".$v['name'], $notificationModel, $settingModel);
        }

        // Stock rendah ≤10
        $lowStockVariants = $variantModel->where('stock <=',10)->where('stock >',0)->findAll();
        foreach($lowStockVariants as $v){
            $product = $productModel->find($v['product_id']);
            $msg = "Stock hampir habis ({$v['stock']} pcs) untuk ".$product['name']." - Variant: ".$v['name'];
            $this->insertNotifIfEnabled('stock_low', $msg, $notificationModel, $settingModel);
        }

        // Stock habis
        $outOfStockVariants = $variantModel->where('stock',0)->findAll();
        foreach($outOfStockVariants as $v){
            $product = $productModel->find($v['product_id']);
            $msg = "Stock habis untuk ".$product['name']." - Variant: ".$v['name'];
            $this->insertNotifIfEnabled('stock_empty', $msg, $notificationModel, $settingModel);
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
