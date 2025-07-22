<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    public function cu()
    {
        return view('service/cu', [
            'pageTitle' => 'Contact Us',
        ]);
    }
     public function cg()
    {
        return view('service/cg', [
            'pageTitle' => 'Coorporate Gift',
        ]);
    }
}
