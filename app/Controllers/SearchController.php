<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductVariantModel;
use CodeIgniter\Controller;

class SearchController extends BaseController
{

    public function index($slug){
        $productModel = new ProductModel();
        $results = $productModel->like('name', $slug)->limit(5)->find();


    }
    public function suggestion()
    {
         $categoryModel = new CategoryModel();
            $productModel = new ProductModel();
            $categories = $categoryModel->findAll();

        $q = $this->request->getGet('q');
                 $results = $productModel
                ->select('product_section_details.detail, categories.name as caty,product_images.image_path as img, products.*,products.slug as slug, product_variants.price as variant_price, product_variants.name as variant_name, product_variants.id as variant_id')
                ->join('product_variants', 'product_variants.product_id = products.id', 'inner')
                ->join('product_images', 'product_variants.id = product_images.variant_id', 'inner')
                ->join('product_sections', 'products.id = product_sections.product_id', 'inner')
                ->join('product_section_details', 'product_section_details.section_id = product_sections.id', 'inner')
                ->join('categories', 'categories.id = products.category_id', 'inner')
                ->groupStart()
                    ->like('products.name', $q)
                    ->orLike('categories.name', $q)
                    ->orLike('product_variants.name', $q)
                    ->orLike('products.description', $q)
                    ->orLike('product_variants.desc', $q)
                    ->orLike('product_section_details.detail', $q)
                ->groupEnd()
                ->groupBy('product_variants.name')
                ->findAll();

            
        $output = '<p class="text-gray-500 mb-2">Search Results:</p>
        <ul class="grid text-center grid-cols-2 sm:grid-cols-4 gap-6">';
        if ($results) {
               
            foreach ($results as $row) {
               $output .= '
               <a href="'.base_url("products/".$row['slug']).'"><img class="h-20 w-20 md:h-40 md:w-40"
               src="'.base_url().'assets/SGV/Category/'.str_replace(' ','-',strtolower($row["caty"])).'/'.str_replace(' ','-',strtolower($row["name"])).'/'.str_replace(' ','-',strtolower($row["variant_name"])).'/'.str_replace(' ','-',strtolower($row["img"])).'" />';
               $output .= '<li>'.$row["name"].' - '.$row["variant_name"].'</li></a>';              
            }
        } else {
            $output .= '<li class="text-gray-400 text-sm">No results found.</li>';
        }

        return $this->response->setBody($output);
    }
}
