<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class AdminController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        if (!isset($user['role']) || $user['role'] == 'user')
        {
            return view('login');
        }
        else
        {
         return view('/admin/index');
        }
    }
}
