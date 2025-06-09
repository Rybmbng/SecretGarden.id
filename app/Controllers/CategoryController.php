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

        $categoryName = str_replace('-', ' ', $slug);

        $category = $categoryModel->where('name', $categoryName)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }

        $products = $productModel->where('category_id', $category['id'])->findAll();

        foreach ($products as &$product) {
            $product['img'] = $product['image'] ?? 'default-product.jpg';
        }

        $data = [
            'category' => $category,
            'products' => $products,
        ];

        echo view('category/index', $data);
    }
}
