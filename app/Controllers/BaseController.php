<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CompanySettingModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\NotificationModel;
use App\Models\FooterLinkModel;
use Config\Services;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['menu'];
    protected $companySetting;
    protected $footerLinks;
    protected $defaultPath;
    protected $notifications = [];


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
        
        $companyModel = new CompanySettingModel();
        $footerModel  = new FooterLinkModel();

        $this->companySetting = $companyModel->first() ?? [
            'name' => 'SecretGarden',
            'logo' => 'assets/SGV/footer/footer.jpg',
            'favicon' => 'assets/SGV/sg.png',
            'tagline' => 'Inspired by Earth, Made For You',
        ];

        $this->footerLinks = $footerModel->orderBy('position', 'ASC')->findAll();




        // --- Notifikasi Produk Otomatis ---
            $productModel = new ProductModel();
            $variantModel = new ProductVariantModel();
            $notificationModel = new NotificationModel();

            $notifications = array();

            // 1. Produk baru
            $newProducts = $productModel->orderBy('created_at','DESC')->limit(3)->findAll();
            foreach($newProducts as $p){
                // Cek apakah notifikasi sudah ada
                $exists = $notificationModel->where('type','product_added')->where('message',"Produk baru ditambahkan: ".$p['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'product_added',
                        'message'=>"Produk baru ditambahkan: ".$p['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // 2. Produk diperbarui
            $editedProducts = $productModel->where('updated_at > created_at')->orderBy('updated_at','DESC')->limit(3)->findAll();
            foreach($editedProducts as $p){
                $exists = $notificationModel->where('type','product_edited')->where('message',"Produk diperbarui: ".$p['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'product_edited',
                        'message'=>"Produk diperbarui: ".$p['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // 3. Variant baru
            $newVariants = $variantModel->orderBy('created_at','DESC')->limit(3)->findAll();
            foreach($newVariants as $v){
                $product = $productModel->find($v['product_id']);
                $exists = $notificationModel->where('type','variant_added')->where('message',"Variant baru untuk produk ".$product['name'].": ".$v['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'variant_added',
                        'message'=>"Variant baru untuk produk ".$product['name'].": ".$v['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // 4. Variant diperbarui
            $editedVariants = $variantModel->where('updated_at > created_at')->orderBy('updated_at','DESC')->limit(3)->findAll();
            foreach($editedVariants as $v){
                $product = $productModel->find($v['product_id']);
                $exists = $notificationModel->where('type','variant_edited')->where('message',"Variant diperbarui untuk produk ".$product['name'].": ".$v['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'variant_edited',
                        'message'=>"Variant diperbarui untuk produk ".$product['name'].": ".$v['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // 5. Stock rendah ≤10
            $lowStockVariants = $variantModel->where('stock <=',10)->where('stock >',0)->findAll();
            foreach($lowStockVariants as $v){
                $product = $productModel->find($v['product_id']);
                $exists = $notificationModel->where('type','stock_low')->where('message',"Stock hampir habis ({$v['stock']} pcs) untuk ".$product['name']." - Variant: ".$v['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'stock_low',
                        'message'=>"Stock hampir habis ({$v['stock']} pcs) untuk ".$product['name']." - Variant: ".$v['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // 6. Stock habis
            $outOfStockVariants = $variantModel->where('stock',0)->findAll();
            foreach($outOfStockVariants as $v){
                $product = $productModel->find($v['product_id']);
                $exists = $notificationModel->where('type','stock_empty')->where('message',"Stock habis untuk ".$product['name']." - Variant: ".$v['name'])->first();
                if(!$exists){
                    $notificationModel->insert([
                        'type'=>'stock_empty',
                        'message'=>"Stock habis untuk ".$product['name']." - Variant: ".$v['name'],
                        'is_read'=>0
                    ]);
                }
            }

            // Ambil notifikasi terbaru untuk header (is_read=0)
            $this->notifications = $notificationModel->where('is_read',0)->orderBy('created_at','DESC')->findAll(5);




        // Share ke semua view
        $renderer = Services::renderer();
        $renderer->setVar('companySetting', $this->companySetting);
        $renderer->setVar('footerLinks', $this->footerLinks);

        $this->defaultPath = [
            'images' => 'uploads/images/',
            'docs'   => 'uploads/documents/',
            'items'   => 'uploads/SG/',
            'assets' => 'assets/'
        ];
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