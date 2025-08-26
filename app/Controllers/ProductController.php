<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\ProductImageModel;


class ProductController extends BaseController
{
    
    public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        $sectionModel   = new \App\Models\ProductSectionModel();
        $detailModel    = new \App\Models\ProductSectionDetailModel();
        $categories = $categoryModel->findAll();

        foreach ($categories as &$category) {
            $category['products'] = $productModel->where('category_id', $category['id'])->findAll();

            foreach ($category['products'] as &$product) {
                $productImageModel = new ProductImageModel();
                $primaryImage = $productImageModel
                    ->where('product_id', $product['id'])
                    ->where('is_primary', true)
                    ->first();

                $product['img'] = $primaryImage['image_path'] ?? 'default-product.jpg';
            }
        }

        $images = [];
        foreach ($categories as $cat) {
            $images[] = [
                'name' => $cat['name'],
                'img'  => $cat['img'] ?? 'default-category.jpg',
                'desc'  => $cat['description'] ?? 'No description available',
            ];
        }
        $sectionsRaw = $sectionModel->where('product_id', $product['id'])->findAll();
        $sections = [];
        foreach ($sectionsRaw as $section) {
            $details = $detailModel->where('section_id', $section['id'])->findAll();
            $sections[$section['type']][] = [
                'header'  => $section['type'],
                'details' => array_column($details, 'detail')
            ];
        }

        $data = [
            'categories' => $categories,
            'sections'      => $sections,
            'images' => $images,
            'pageTitle'=> 'Products',

        ];

        echo view('product/index', $data);
    }

public function detail($slug)
{
    $productModel   = new ProductModel();
    $variantModel   = new ProductVariantModel();
    $imageModel     = new ProductImageModel();
    $categoryModel  = new CategoryModel();
    $sectionModel   = new \App\Models\ProductSectionModel();
    $detailModel    = new \App\Models\ProductSectionDetailModel();

    $product = $productModel->where('slug', $slug)->first();
    if (!$product) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
    }

    $variants = $variantModel->where('product_id', $product['id'])->findAll();

    $variantImages = $imageModel
        ->whereIn('variant_id', array_column($variants, 'id'))
        ->findAll();

    $variantImageMap = [];
    foreach ($variantImages as $img) {
        $vid = (int)$img['variant_id'];
        $variantImageMap[$vid][] = $img['image_path'];
    }

    foreach ($variants as &$variant) {
        $vid = (int)$variant['id'];
        $variant['images'] = $variantImageMap[$vid] ?? [];
        $variant['image_path'] = !empty($variant['images']) ? $variant['images'][0] : null; // thumbnail
    }

    $galleryImages = $imageModel
        ->where('product_id', $product['id'])
        ->where('variant_id', null)
        ->findAll();

    $useVariantSlug = '';

    $category = $categoryModel->find($product['category_id']);
    $categorySlug = strtolower(str_replace(' ', '-', $category['name']));

    $sectionsRaw = $sectionModel->where('product_id', $product['id'])->findAll();
    $sections = [];
    foreach ($sectionsRaw as $section) {
        $details = $detailModel->where('section_id', $section['id'])->findAll();
        $sections[$section['type']][] = [
            'header'  => $section['header'],
            'details' => array_column($details, 'detail')
        ];
    }

    $relatedProducts = $productModel
    ->select('products.*, categories.name AS category_name, MIN(product_variants.price) AS variant_price')
    ->join('categories', 'categories.id = products.category_id')
    ->join('product_variants', 'product_variants.product_id = products.id')
    ->where('products.slug !=', $slug)
    ->groupBy('products.id')
    ->findAll(6);
    
    // Path galeri
    $productSlug  = strtolower(str_replace(' ', '-', $product['name']));
    $galleryPath  = "assets/SGV/Category/{$categorySlug}/{$productSlug}";
    $useVariantSlug = str_replace(" ", "-", $useVariantSlug);
    if (!empty($useVariantSlug)) {
        $galleryPath .= "/{$useVariantSlug}";
    }

    return view('product/detail', [
        'product'             => $product,
        'variants'            => $variants,
        'galleryImages'       => $galleryImages,
        'category'            => $category,
        'sections'            => $sections,
        'galleryPath'         => $galleryPath, 
        'categorySlug'        => $categorySlug,
        'productSlug'         => $productSlug,
        'recommendedProducts' => $relatedProducts,
        'pageTitle'           => $product['name'],
        'useVariantSlug'      => $useVariantSlug,
    ]);
}




public function search()
{
    $query = $this->request->getGet('q');
    if (!$query) {
        return redirect()->to('/product');
    }

    $productModel = new ProductModel();
    $products = $productModel->like('name', $query)->findAll();

    foreach ($products as &$product) {
        $product['img'] = $product['image'] ?? 'default-product.jpg';
    }

    return view('product/search', [
        'products' => $products, 
        'query' => $query,            
        'pageTitle' => 'Search Product',
        ]);

}

public function cart()
{
    return view('product/cart',[
        'pageTitle'=> 'Cart',
    ]);
}

}