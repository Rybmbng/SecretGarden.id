<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $categories = array_column($this->productModel->getCategories(), 'category');

        $data = [
            'title' => 'All Products',
            'products' => $this->productModel->getAllProducts(),
            'categories' => $categories,
            'activeCategory' => 'all',
        ];

        return view('products', $data);
    }

    public function category($category)
    {
        $categories = array_column($this->productModel->getCategories(), 'category');

        if (!in_array($category, $categories)) {
            throw PageNotFoundException::forPageNotFound("Category '{$category}' not found.");
        }

        $data = [
            'title' => 'Category: ' . ucfirst($category),
            'products' => $this->productModel->getProductsByCategory($category),
            'categories' => $categories,
            'activeCategory' => $category,
        ];

        return view('products', $data);
    }

    public function detail($slug)
    {
        $product = $this->productModel->getProductBySlug($slug);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound("Product not found");
        }

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'categories' => array_column($this->productModel->getCategories(), 'category'),
            'activeCategory' => $product['category'],
        ];

        return view('product_detail', $data);
    }
}
