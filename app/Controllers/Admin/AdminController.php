<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class AdminController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Dashboard admin
    public function index()
    {
        return view('admin/dashboard');
    }

    // List produk
    public function products()
    {
        $data['products'] = $this->productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->findAll();

        return view('admin/products/index', $data);
    }

    // List kategori
    public function categories()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }

    // Tambah, edit, hapus produk & kategori bisa ditambahkan menyusul
}
