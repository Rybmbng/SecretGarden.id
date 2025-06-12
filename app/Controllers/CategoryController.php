<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryController extends BaseController
{
    public function index($slug = null)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $category = $categoryModel->where('slug', $slug)->first();
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori tidak ditemukan");
        }

        $products = $productModel->where('category_id', $category['id'])->findAll();

        return view('category/detail', [
            'category' => $category,
            'products' => $products,
        ]);

    }
}
