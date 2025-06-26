<?php

namespace App\Controllers;
use App\Models\SliderModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\ProductImageModel;

class HomeController extends BaseController
{
    public function index()
    {

        $sliderModel = new SliderModel();
        $productModel = new ProductModel;

        $slider = $sliderModel->getSliders();
        $product = $productModel->sliderHome(4);
        
        $mainProducts = $productModel->mainProduct();
        $data=[
            'products' => $product,
            'sliders' => $slider,
            'mainProduct'=>$mainProducts,
            'pageTitle'=> 'Home',
        ];
        return view('home', $data);
    }
}
