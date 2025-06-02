<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class ProductController extends BaseController
{
    public function index()
    {
     
        return view('product/index');
    }

  
}