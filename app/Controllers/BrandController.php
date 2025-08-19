<?php

namespace App\Controllers;
use App\Models\BrandModel;
class BrandController extends BaseController
{
    public function index()
    {
        $brandModel = new BrandModel;

        $brands = $brandModel->where('status','1')->findAll();
        

        return view('brand/index', [
            'pageTitle' => 'Brand Page',
            'brands'=> $brands,
        ]);
    }
}
