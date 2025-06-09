<?php

namespace App\Controllers;
use App\Models\SliderModel;

class HomeController extends BaseController
{
    public function index()
    {
        $sliderModel = new SliderModel();
        $data['sliders'] = $sliderModel->getSliders();

        return view('home', $data);
    }
}
