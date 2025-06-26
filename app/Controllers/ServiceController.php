<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    public function index()
    {
        return view('service/index');
    }
}
