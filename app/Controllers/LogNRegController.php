<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LogNRegModel;
use CodeIgniter\Session\Session;

class LogNRegController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        $this->authCheck();
    }

    protected function authCheck()
    {
        // Example: check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            // Redirect to login page if not authenticated
            return redirect()->to('/login')->send();
            exit;
        }
    }

    public function index()
    {
        return view('login');
    }
}
