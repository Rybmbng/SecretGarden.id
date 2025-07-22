<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\ProductSectionModel;
use App\Models\ProductSectionDetailModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;

class ProductAdminController extends BaseController
{
    protected $productModel;
    protected $variantModel;
    protected $sectionModel;
    protected $sectionDetailModel;
    protected $imageModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel        = new ProductModel();
        $this->variantModel        = new ProductVariantModel();
        $this->sectionModel        = new ProductSectionModel();
        $this->sectionDetailModel  = new ProductSectionDetailModel();
        $this->imageModel          = new ProductImageModel();
        $this->categoryModel       = new CategoryModel();
    }
    public function index()
    {
        $data['products'] = $this->productModel->withCategory()->findAll();
        return view('admin/products/index', $data);
    }

    public function create()
    {
        $categories = $this->categoryModel->findAll();

        return view('admin/products/create', [
            'categories' => $categories,
        ]);
    }

   public function store()
{
    $db = \Config\Database::connect();
    $db->transBegin();

    $request = service('request');

    try {
        $productData = [
            'name'        => $request->getPost('name'),
            'category_id' => $request->getPost('category_id'),
            'description' => $request->getPost('description'),
            'slug'        => url_title($request->getPost('name'), '-', true),
        ];

        if (!$this->productModel->insert($productData)) {
            throw new \Exception('Gagal menyimpan produk utama.');
        }

        $productId = $this->productModel->getInsertID();
        $productSlug = url_title($productData['name'], '-', true);
        $category = $this->categoryModel->find($productData['category_id']);
        $categoryPath = $category['path'] ?? 'default';

        $variantNames  = $request->getPost('variant_name');
        $variantPrices = $request->getPost('variant_price');
        $variantSkus   = $request->getPost('variant_sku');
        $variantStocks = $request->getPost('variant_stock');
        $variantDescs  = $request->getPost('variant_desc');

        foreach ($variantNames as $i => $name) {
            $variantSlug = url_title($name, '-', true);
            $uploadPath = FCPATH . "assets/SGV/Category/{$categoryPath}/{$productSlug}/{$variantSlug}";

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $variantData = [
                'product_id' => $productId,
                'name'       => $name,
                'price'      => $variantPrices[$i] ?? 0,
                'sku'        => $variantSkus[$i] ?? '',
                'stock'      => $variantStocks[$i] ?? 0,
                'desc'       => $variantDescs[$i] ?? '',
                'main'       => $i == 0 ? 1 : 0,
            ];

            if (!$this->variantModel->insert($variantData)) {
                log_message('error', '❌ Gagal insert varian ke-' . $i . ': ' . json_encode($this->variantModel->errors()));
                continue;
            }

           
            $imageFiles = $request->getFiles()["variant_images_{$i}"] ?? [];
            $first = true;
            sleep(1);
            foreach ($imageFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $imageName = $file->getRandomName();
                    $fullPath = $uploadPath . '/' . $imageName;

                    \Config\Services::image()
                        ->withFile($file)
                        ->resize(800, 800, true, 'center')
                        ->save($fullPath, 75);
                    $variantId = $this->variantModel->getInsertID();
                    
                    $isPrimary = ($i === 0 && $first) ? 1 : 0;
                   
                    $imageInsert = [
                        'product_id' => (int)$productId,
                        'variant_id' => (int)$variantId,
                        'image_path' => $imageName,
                        'is_primary' => $isPrimary,
                    ];
                    
                    $db->table('product_images')->insert($imageInsert);
                     if ($i == 0 && $first) {
                        $globalPath = FCPATH . "assets/SGV/Category/{$categoryPath}/{$productSlug}";
                        if (!is_dir($globalPath)) {
                            mkdir($globalPath, 0777, true);
                        }
                        copy($fullPath, $globalPath . '/' . $imageName);
                    }

                    $first = false;
                }
            }
        }

        $sectionTypes   = $request->getPost('section_type');
        $sectionHeaders = $request->getPost('section_header');
        $sectionDetails = $request->getPost('section_detail');

        foreach ($sectionTypes as $i => $type) {
            if (!$type) continue;

            if (!$this->sectionModel->insert([
                'product_id' => $productId,
                'type'       => $type,
                'header'     => $sectionHeaders[$i] ?? '',
            ])) {
                log_message('error', 'Gagal insert section ke-' . $i);
                continue;
            }

            $sectionId = $this->sectionModel->getInsertID();

            $this->sectionDetailModel->insert([
                'section_id' => $sectionId,
                'detail'     => $sectionDetails[$i] ?? '',
            ]);
        }

        // ====== COMMIT ======
        $db->transCommit();
        return redirect()->to('/admin/products/edit/' . $productId)
                         ->with('success', 'Produk berhasil ditambahkan.');
    } catch (\Throwable $e) {
        $db->transRollback();
        log_message('error', 'Transaction rollback: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function edit($id)
{
    $product = $this->productModel->find($id);
    if (!$product) {
        return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
    }

    $category = $this->categoryModel->find($product['category_id']);
    $product['category_path'] = $category['path'] ?? 'default';
    $variants = $this->variantModel->where('product_id', $id)->findAll();
    foreach ($variants as &$variant) {
        $variant['images'] = $this->imageModel->where('variant_id', $variant['id'])->where('is_primary', 0)->findAll();
    }
    $mainImage = $this->imageModel->where('product_id', $product['id'])->where('is_primary', 1)->findAll();
    $sections = $this->sectionModel->where('product_id', $id)->findAll();
    foreach ($sections as &$section) {
        $section['detail'] = $this->sectionDetailModel->where('section_id', $section['id'])->first()['detail'] ?? '';
    }

    
    $categories = $this->categoryModel->findAll();

    // dd([
    //     'product'    => $product,
    //     'variants'   => $variants,
    //     'imageMain'   => $mainImage,
    //     'images'   => $variant['images'],
    //     'sections'   => $sections,
    //     'categories' => $categories,
    // ]);
    return view('admin/products/edit', [
        'product'    => $product,
        'variants'   => $variants,
        'imageMain'   => $mainImage,
        'sections'   => $sections,
        'categories' => $categories,
        'Nav'=>'Edit Products'
    ]);
}

public function delete($id)
{
    $product = $this->productModel->find($id);
    if (!$product) {
        return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
    }

    $this->productModel->delete($id); 

    return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
}

}