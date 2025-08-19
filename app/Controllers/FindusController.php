<?php

namespace App\Controllers;

use App\Models\StoreModel;

class FindusController extends BaseController
{
    public function index()
    {
        $storeModel = new StoreModel();

        $data['stores'] = $storeModel->findAll();

        return view('findus/index', $data);
    }
}
