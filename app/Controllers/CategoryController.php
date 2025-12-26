<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\ProductVariantModel;

class CategoryController extends BaseController
{
     public function index($slug = null)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $category = $categoryModel->findall();

        if ($category) {
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('p.name as pname,p.main_images as img, pv.*, pim.*,c.name as catname' );
            $builder->join('products p', 'c.id = p.category_id');
            $builder->join('product_variants pv', 'pv.product_id = p.id');
            $builder->join('product_images pim', 'pv.id = pim.variant_id');
            $builder->groupBy('p.id');


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
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('p.name as pname,p.main_images as img, pv.*, pim.*');
            $builder->join('products p', 'c.id = p.category_id');
            $builder->join('product_variants pv', 'pv.product_id = p.id');
            $builder->join('product_images pim', 'pv.id = pim.variant_id');;


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
        }

        $allCategories = $categoryModel->findAll();
        foreach ($allCategories as &$categories) {
            $categories['products'] = $productModel->where('category_id', $categories['id'])->findAll();
        }
        $data = [
            'pageTitle' => "ALL PRODUCT",
            'category' => $category,
            'products' => $category['products'],
            'catname' => $allCategories,
            'allproduct' => $categories['products'],
            'primaryImage' => $primaryImage['image_path'] ?? 'default-product.jpg',
            'slug' => $slug,
        ];

        echo view('category/index', $data);
    }

   public function detail($slug = null)
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
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('p.name as pname,p.main_images as img, pv.*, pim.*');
            $builder->join('products p', 'c.id = p.category_id');
            $builder->join('product_variants pv', 'pv.product_id = p.id');
            $builder->join('product_images pim', 'pv.id = pim.variant_id');;


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
        }

        $allCategories = $categoryModel->findAll();
        foreach ($allCategories as &$categories) {
            $categories['products'] = $productModel->where('category_id', $categories['id'])->findAll();
        }
        $data = [
            'pageTitle' => $categoryName,
            'category' => $category,
            'products' => $category['products'],
            'catname' => $allCategories,
            'allproduct' => $categories['products'],
            'primaryImage' => $primaryImage['image_path'] ?? 'default-product.jpg',
            'slug' => $slug,
        ];

        echo view('category/detail', $data);
    }


   public function details($slug, $slug1)
        {
            $categoryModel = new CategoryModel();
            $productModel = new ProductModel();
            $productImageModel = new ProductImageModel();

            $categoryName = str_replace('-', ' ', $slug);
            $productName = str_replace('-', ' ', $slug1);

            // ambil kategori
            $category = $categoryModel->where('name', $categoryName)->first();

            if ($category) {
                $search = $this->request->getGet('search');
                $sort   = $this->request->getGet('sort');
                $builder = $productModel
                    ->select('
                        categories.name as caty,
                        products.*,
                        product_variants.price as variant_price,
                        product_variants.name as variant_name,
                        product_variants.id as variant_id
                    ')
                    ->join('product_variants', 'product_variants.product_id = products.id', 'inner')
                    ->join('categories', 'categories.id = products.category_id', 'inner')
                    ->where('products.category_id', $category['id'])
                    ->where('products.name', $productName);

                // search
                if (!empty($search)) {
                    $builder->like('product_variants.name', $search);
                }

                // sort
                switch ($sort) {
                    case 'price_asc':
                        $builder->orderBy('product_variants.price', 'ASC');
                        break;
                    case 'price_desc':
                        $builder->orderBy('product_variants.price', 'DESC');
                        break;
                    case 'name_asc':
                        $builder->orderBy('product_variants.name', 'ASC');
                        break;
                    case 'name_desc':
                        $builder->orderBy('product_variants.name', 'DESC');
                        break;
                    default:
                        $builder->orderBy('product_variants.id', 'ASC');
                        break;
                }

                $variants = $builder->groupBy('product_variants.id')->findAll();
                foreach ($variants as &$variant) {
                    $primaryImage = $productImageModel
                        ->where('variant_id', $variant['variant_id'])
                        ->first();

                    $variant['img'] = $primaryImage['image_path'] ?? 'default-product.jpg';
                }

                $primaryImage = !empty($variants) ? $variants[0] : [];
            } else {
                $category = [];
                $variants = [];
                $primaryImage = [];
            }

            $allCategories = $categoryModel->findAll();
            foreach ($allCategories as &$cat) {
                $cat['products'] = $productModel
                    ->where('category_id', $cat['id'])
                    ->findAll();
            }

            echo print_r($variants);

            $data = [
                'pageTitle'    => $slug1,
                'category'     => $category,
                'products'     => $variants,
                'catname'      => $allCategories,
                'primaryImage' => $primaryImage['img'] ?? 'default-product.jpg',
                'slug'         => $slug,
            ];

            return view('category/detailslug', $data);
        }


}