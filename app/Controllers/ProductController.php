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

        $categories = $categoryModel->findAll();

        foreach ($categories as &$category) {
            $category['products'] = $productModel->where('category_id', $category['id'])->findAll();

            // Untuk tiap produk, tambahkan gambar utama (primary)
            foreach ($category['products'] as &$product) {
                // Load gambar utama
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
            ];
        }

        $data = [
            'categories' => $categories,
            'images' => $images,
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
    $variantImages = $imageModel->where('product_id', $product['id'])->where('variant_id IS NOT NULL', null, false)->findAll();

    $variantImageMap = [];
    foreach ($variantImages as $img) {
        if (!isset($variantImageMap[$img['variant_id']])) {
            $variantImageMap[$img['variant_id']] = [];
        }
        $variantImageMap[$img['variant_id']][] = $img['image_path'];
    }

    foreach ($variants as &$variant) {
        $variant['images'] = $variantImageMap[$variant['id']] ?? [];
        $variant['image_path'] = $variant['images'][0] ?? null;
    }

    // Ambil gallery images non-variant
    $galleryImages = $imageModel->where('product_id', $product['id'])->where('variant_id', null)->findAll();

    // Ambil kategori
    $category = $categoryModel->find($product['category_id']);

    // Ambil sections (story, directions, characteristics)
    $sectionsRaw = $sectionModel->where('product_id', $product['id'])->findAll();
    $sections = [];

    foreach ($sectionsRaw as $section) {
        $details = $detailModel->where('section_id', $section['id'])->findAll();
        $sections[$section['type']][] = [
            'header'  => $section['type'],
            'details' => array_column($details, 'detail')
        ];
    }
    $relatedProducts = [
    ['slug' => 'product-1', 'name' => 'Sample 1', 'thumbnail' => 'thumb1.jpg'],
    ['slug' => 'product-2', 'name' => 'Sample 2', 'thumbnail' => 'thumb2.jpg'],
    ];

    $data = [
        'product'       => $product,
        'variants'      => $variants,
        'galleryImages' => $galleryImages,
        'category'      => $category,
        'sections'      => $sections,
        'relatedProducts' => $relatedProducts, // Contoh data produk terkait
    ];
    

    return view('product/detail', $data);
}



}
