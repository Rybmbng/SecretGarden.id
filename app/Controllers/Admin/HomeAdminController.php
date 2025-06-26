<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeAdminController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        // if (!isset($user['role']) || $user['role'] == 'user')
        // {
        //     return view('login');
        // }
        // else
        // {
        //  return view('/admin/index');
        // }
         return view('/admin/index');

    }
}
