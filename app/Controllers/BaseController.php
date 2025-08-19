<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CompanySettingModel;
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