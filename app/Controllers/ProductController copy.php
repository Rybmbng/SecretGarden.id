<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    public function index()
    {

       $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getCategoriesWithProducts();
        return view('product/index', $data);
    }

  
}