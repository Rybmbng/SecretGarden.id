<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;

class CategoryController extends BaseController
{
    public function index($slug = null)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $categoryName = str_replace('-', ' ', $slug);

            $category = $categoryModel->where('name', $categoryName)->first();

            if ($category) {
                $db = \Config\Database::connect();
                $builder = $db->table('categories c');
                $builder->select('pv.*, pim.*');
                $builder->join('products p', 'c.id = p.category_id');
                $builder->join('product_variants pv', 'pv.product_id = p.id');
                $builder->join('product_images pim', 'pim.product_id = p.id');
                $builder->where('c.name', $categoryName);
                $builder->orderBy('pv.`product_id`', 'ASC');

                $products = $builder->get()->getResultArray();
                $category['products'] = $products;
                $primaryImage = !empty($products) ? $products[0] : [];
            } else {
                $category = [];
                $primaryImage = [];
            }
        $data = [
            'category' => $category,
            'products' => $category['products'],
            'primaryImage' => $primaryImage['image_path'] ?? 'default-product.jpg',
            'slug' => $slug,
        ];
       
     

        echo view('category/index', $data);
    }
}
