<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;

class CategoryController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $categories = $categoryModel->findAll();

        $db = \Config\Database::connect();

        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort');

        $allProducts = [];
        $primaryImage = [];

        if ($categories) {
            foreach ($categories as &$category) {
                $builder = $db->table('products p');
                $builder->select('p.name as pname, pv.*, pim.*');
                $builder->join('product_variants pv', 'pv.product_id = p.id');
                $builder->join('product_images pim', 'pv.id = pim.variant_id');
                $builder->where('pim.is_primary', 1);
                $builder->where('p.category_id', $category['id']);

                if (!empty($search)) {
                    $builder->like('p.name', $search);
                }

                switch ($sort) {
                    case 'price_asc':
                        $builder->orderBy('pv.price', 'ASC');
                        break;
                    case 'price_desc':
                        $builder->orderBy('pv.price', 'DESC');
                        break;
                    case 'name_asc':
                        $builder->orderBy('p.name', 'ASC');
                        break;
                    case 'name_desc':
                        $builder->orderBy('p.name', 'DESC');
                        break;
                    default:
                        $builder->orderBy('pv.product_id', 'ASC');
                        break;
                }

                $products = $builder->get()->getResultArray();
                $category['products'] = $products;
                if (!empty($products) && empty($primaryImage)) {
                    $primaryImage = $products[0];
                }
                $allProducts = array_merge($allProducts, $products);
            }
            unset($category);
        } else {
            $categories = [];
        }

        $data = [
            'category' => $categories,
            'products' => $allProducts,
            'primaryImage' => $primaryImage['image_path'] ?? 'default-product.jpg',
        ];

        echo view('category/index', $data);
    }

   public function detail($slug)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $categoryName = str_replace('-', ' ', $slug);
        $category = $categoryModel->where('name', $categoryName)->first();

        if ($category) {
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('p.name as pname,p.main_images as img, pv.*, pim.*');
            $builder->join('products p', 'c.id = p.category_id');
            $builder->join('product_variants pv', 'pv.product_id = p.id');
            $builder->join('product_images pim', 'pv.id = pim.variant_id');
            $builder->where('c.name', $categoryName);
            $builder->groupBy('p.id');

            // Tambahkan FILTER dan SORT
            $search = $this->request->getGet('search');
            $sort = $this->request->getGet('sort');

            if (!empty($search)) {
                $builder->like('p.name', $search);
            }

            switch ($sort) {
                case 'price_asc':
                    $builder->orderBy('pv.price', 'ASC');
                    break;
                case 'price_desc':
                    $builder->orderBy('pv.price', 'DESC');
                    break;
                case 'name_asc':
                    $builder->orderBy('p.name', 'ASC');
                    break;
                case 'name_desc':
                    $builder->orderBy('p.name', 'DESC');
                    break;
                default:
                    $builder->orderBy('pv.product_id', 'ASC');
                    break;
            }

            $products = $builder->get()->getResultArray();
            $category['products'] = $products;
            $primaryImage = !empty($products) ? $products[0] : [];
        } else {
            $category = [];
            $primaryImage = [];
        }

       
        $data = [
            'pageTitle' => $categoryName,
            'category' => $category,
            'products' => $category['products'],
            'primaryImage' => $primaryImage['image_path'] ?? 'default-product.jpg',
            'slug' => $slug,
        ];

        echo view('category/index', $data);
    }

}
