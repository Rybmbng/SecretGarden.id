<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class CoorporategiftController extends BaseController
{
    protected $emailModel;
    protected $messageModel;

    public function __construct()
    {
      
    }

    public function index()
    {
        return view('service/cg/index');
    }
}
