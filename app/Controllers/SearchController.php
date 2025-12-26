<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;

class SearchController extends BaseController
{
    public function query()
    {
        $q = $this->request->getGet('q');
        if (!$q) return $this->response->setJSON([]);

        $productModel       = new ProductModel();
        $variantModel       = new ProductVariantModel();
        $variantImageModel  = new ProductImageModel();
        $categoryModel      = new CategoryModel();

        $results = [];

        $products = $productModel->like('name', $q)->findAll(5);
        foreach ($products as $p) {
            $category = $categoryModel->find($p['category_id']);
            $categorySlug = strtolower(str_replace(' ', '-', $category['name']));
            $productSlug  = strtolower(str_replace(' ', '-', $p['slug']));
            $mainImage    = $p['main_images'] ?? null;
            $thumbnail    = $mainImage ? base_url("assets/SGV/Category/{$categorySlug}/{$productSlug}/{$mainImage}") : null;

            $results[] = [
                'type' => 'product',
                'name' => $p['name'],
                'url'  => base_url('products/'.$p['slug']),
                'image'=> $thumbnail
            ];
        }

        $variants = $variantModel->like('name', $q)->findAll(5);
        foreach ($variants as $v) {
            $product = $productModel->find($v['product_id']);
            $category = $categoryModel->find($product['category_id']);
            $categorySlug = strtolower(str_replace(' ', '-', $category['name']));
            $productSlug  = strtolower(str_replace(' ', '-', $product['slug']));
            $variantName  = strtolower(str_replace(' ', '-', $v['name']));

            $variantImage = $variantImageModel->where('variant_id', $v['id'])->first();
            $imgPath = $variantImage['image_path'] ?? null;
            $thumbnail = $imgPath ? base_url("assets/SGV/Category/{$categorySlug}/{$productSlug}/{$variantName}/{$imgPath}") : null;

            $results[] = [
                'type' => 'variant',
                'name' => $v['name'] . ' ('. $product['name'] .')',
                'url'  => base_url('products/'.$product['slug'].'#'.$v['slug']),
                'image'=> $thumbnail
            ];
        }

        $categories = $categoryModel->like('name', $q)->findAll(5);
        foreach ($categories as $c) {
            $slugCat = strtolower(str_replace(' ', '-', $c['slug'] ?? $c['name']));
            $catImage = $c['img'] ?? null;
            $thumbnail = $catImage ? base_url("assets/SGV/Category/{$slugCat}/{$catImage}") : null;

            $results[] = [
                'type' => 'category',
                'name' => $c['name'],
                'url'  => base_url('category/'.$c['name']),
                'image'=> $thumbnail
            ];

            $productsInCat = $productModel->where('category_id', $c['id'])->findAll(5);
            foreach ($productsInCat as $p) {
                $productSlug  = strtolower(str_replace(' ', '-', $p['slug']));
                $mainImage    = $p['main_images'] ?? null;
                $thumbnail    = $mainImage ? base_url("assets/SGV/Category/{$slugCat}/{$productSlug}/{$mainImage}") : null;

                $results[] = [
                    'type' => 'product',
                    'name' => $p['name'] . ' (Category: '.$c['name'].')',
                    'url'  => base_url('products/'.$p['slug']),
                    'image'=> $thumbnail
                ];
            }
        }

        return $this->response->setJSON($results);
    }
}