<?php

namespace App\Controllers;

class BrandController extends BaseController
{
    public function index()
    {
        return view('brand/index', [
            'pageTitle' => 'Brand Page',
        ]);
    }
}
