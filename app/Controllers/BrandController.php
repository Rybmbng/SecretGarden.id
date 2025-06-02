<?php

namespace App\Controllers;

class BrandController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Brand Page';
        return view('brand', $data);
    }
}
