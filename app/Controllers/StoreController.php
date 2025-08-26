<?php
namespace App\Controllers;
use App\Models\StoreModel;
use App\Models\StoreImageModel;

class StoreController extends BaseController
{
    public function index()
    {
        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->findAll();
        return view('findus/index', $data);
    }

    public function detail($slug)
    {
        $storeModel = new StoreModel();
        $storeImageModel = new StoreImageModel();

        $store = $storeModel->where('slug', $slug)->first();
        if (!$store) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Store tidak ditemukan");
        }

        $images = $storeImageModel->where('store_id', $store['id'])->findAll();

        $data = [
            'store'  => $store,
            'images' => $images
        ];

        return view('findus/detail', $data);
    }
}
