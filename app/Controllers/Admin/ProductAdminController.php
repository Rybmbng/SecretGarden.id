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
    protected $db;
    const WRITEPATH  = WRITEPATH;
    const STATUSPATH = WRITEPATH . 'compress_status/';


    public function __construct()
    {
        $this->productModel        = new ProductModel();
        $this->variantModel        = new ProductVariantModel();
        $this->sectionModel        = new ProductSectionModel();
        $this->sectionDetailModel  = new ProductSectionDetailModel();
        $this->imageModel          = new ProductImageModel();
        $this->categoryModel       = new CategoryModel();
        $this->db = \Config\Database::connect();
        

    }
    public function index()
    {
        $data['products'] = $this->productModel->withCategory()->findAll();

        $data['pageTitle'] = 'Product Management';
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
    
            $productName = $request->getPost('name');
            $productSlug = url_title($productName, '-', true);
            $category    = $this->categoryModel->find($request->getPost('category_id'));
            $categoryPath = strtolower($category['path'] ?? 'default');

            $mainUploadPath = FCPATH . "assets/SGV/Category/{$categoryPath}/{$productSlug}";

            if (!is_dir($mainUploadPath)) {
                mkdir($mainUploadPath, 0777, true);
            }

            $mainImageName = null;
            $mainVideoName = null;
            $mainImageFile = $request->getFile('main_images');
            if ($mainImageFile && $mainImageFile->isValid() && !$mainImageFile->hasMoved()) {
                $mainImageName = $mainImageFile->getRandomName();
                $mainImageFile->move($mainUploadPath, $mainImageName);
            }
            $mainVideoFile = $request->getFile('main_videos');
            if ($mainVideoFile && $mainVideoFile->isValid() && !$mainVideoFile->hasMoved()) {
                $mainVideoName = $mainVideoFile->getRandomName();
                $mainVideoFile->move($mainUploadPath, $mainVideoName);
            }

            $productData = [
                'name'        => $productName,
                'category_id' => $request->getPost('category_id'),
                'description' => $request->getPost('description'),
                'slug'        => $productSlug,
                'main_images' => $mainImageName,
                'main_videos' => $mainVideoName,
            ];

            if (!$this->productModel->insert($productData)) {
                throw new \Exception('Gagal menyimpan produk utama.');
            }
            $productId = $this->productModel->getInsertID();

            $variantNames  = $request->getPost('variant_name');
            $variantPrices = $request->getPost('variant_price');
            $variantSkus   = $request->getPost('variant_sku');
            $variantStocks = $request->getPost('variant_stock');
            $variantDescs  = $request->getPost('variant_desc');

            foreach ($variantNames as $i => $name) {
                $variantSlug = url_title($name, '-', true);
                $variantUploadPath = $mainUploadPath . '/' . $variantSlug;
                if (!is_dir($variantUploadPath)) mkdir($variantUploadPath, 0777, true);

                $variantData = [
                    'product_id' => $productId,
                    'name'       => $name,
                    'price'      => $variantPrices[$i] ?? 0,
                    'sku'        => $variantSkus[$i] ?? '',
                    'stock'      => $variantStocks[$i] ?? 0,
                    'desc'       => $variantDescs[$i] ?? '',
                    'main'       => 0,
                ];
                if (!$this->variantModel->insert($variantData)) {
                    log_message('error', 'Gagal insert varian ke-' . $i);
                    continue;
                }
                $variantId = $this->variantModel->getInsertID();

                $imageFiles = $request->getFiles()["variant_images_{$i}"] ?? [];
                foreach ($imageFiles as $file) {
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $imageName = $file->getRandomName();
                        $file->move($variantUploadPath, $imageName);

                        $db->table('product_images')->insert([
                            'product_id' => $productId,
                            'variant_id' => $variantId,
                            'image_path' => $imageName,
                            'is_primary' => 0,
                        ]);
                    }
                }
            }

            // ====== INSERT SECTIONS ======
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

    return view('admin/products/edit', [
        'product'    => $product,
        'variants'   => $variants,
        'imageMain'   => $mainImage,
        'sections'   => $sections,
        'categories' => $categories,
        'Nav' =>'Edit Products',
        'pageTitle' => $product['name'],
    ]);
}
public function update($id)
    {
        $product = $this->productModel->find($id);
        if(!$product) return redirect()->back()->with('error', 'Product not found');

        $data = $this->request->getPost();

        $updateProduct = [
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
        ];

        $category = (new \App\Models\CategoryModel())->find($product['category_id']);
        $categoryPath = strtolower($category['path'] ?? 'default');
        $uploadPath   = FCPATH . 'assets/SGV/Category/' . $categoryPath . '/' . strtolower($product['slug']);

        // pastikan direktori ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $updateProduct = [];

        // Upload main image
        $mainImage = $this->request->getFile('main_images');
        if ($mainImage && $mainImage->isValid() && !$mainImage->hasMoved()) {
            $newName = $mainImage->getRandomName();
            $mainImage->move($uploadPath, $newName);
            $updateProduct['main_images'] = $newName;
        }

        // Upload main video
        $mainVideo = $this->request->getFile('main_videos');
        if ($mainVideo && $mainVideo->isValid() && !$mainVideo->hasMoved()) {
            $newName = $mainVideo->getRandomName();
            $mainVideo->move($uploadPath, $newName);
            $updateProduct['main_videos'] = $newName;
        }

        // Update ke database
        if (!empty($updateProduct)) {
            $this->productModel->update($id, $updateProduct);
        }


        $variantNames  = $data['variant_name'] ?? [];
        $variantPrices = $data['variant_price'] ?? [];
        $variantStocks = $data['variant_stock'] ?? [];
        $variantSkus   = $data['variant_sku'] ?? [];
        $variantDescs  = $data['variant_desc'] ?? [];

        foreach($variantNames as $vId => $name){
            $variantData = [
                'name' => $name,
                'price' => $variantPrices[$vId] ?? 0,
                'stock' => $variantStocks[$vId] ?? 0,
                'sku'   => $variantSkus[$vId] ?? '',
                'desc'  => $variantDescs[$vId] ?? ''
            ];

            if(str_starts_with($vId, 'new_')){
                $variantData['product_id'] = $id;
                $variantId = $this->variantModel->insert($variantData, true);
            } else {
                $this->variantModel->update($vId, $variantData);
                $variantId = $vId;
            }

            $files = $this->request->getFiles();
            $key = 'variant_images_' . $vId;
            if(isset($files[$key])){
                $category = (new \App\Models\CategoryModel())->find($product['category_id']);
                $categoryPath = $category['path'] ?? 'default';
                $folderBase = FCPATH . 'assets/SGV/Category/' . strtolower($categoryPath) . '/' . strtolower($product['slug']) . '/' . strtolower(str_replace(' ', '', $name));
                if(!is_dir($folderBase)) mkdir($folderBase, 0755, true);

                foreach($files[$key] as $file){
                    if($file && $file->isValid() && !$file->hasMoved()){
                        $fileName = $file->getRandomName();
                        $file->move($folderBase, $fileName);

                        $this->db->table('product_images')->insert([
                            'variant_id' => $variantId,
                            'image_path' => $fileName
                        ]);
                    }
                }
            }
        }

        // ===== Sections =====
        $this->sectionModel->where('product_id', $id)->delete();
        $sectionHeaders = $data['section_header'] ?? [];
        $sectionDetails = $data['section_detail'] ?? [];

        foreach($sectionHeaders as $i => $header){
            if(trim($header) !== ''){
                $this->sectionModel->insert([
                    'product_id' => $id,
                    'header' => $header,
                    'detail' => $sectionDetails[$i] ?? ''
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function delete_variant($id)
    {
    $variantModel = new \App\Models\ProductVariantModel();
    $variant = $variantModel->find($id);
    if (!$variant) {
        return $this->response->setJSON(['success' => false, 'message' => 'Variant not found']);
    }

    $productModel = new \App\Models\ProductModel();
    $product = $productModel->find($variant['product_id']);
    
    $db = \Config\Database::connect();
    $images = $db->table('product_images')->getWhere(['variant_id' => $id])->getResultArray();
    foreach ($images as $img) {
        $category = (new \App\Models\CategoryModel())->find($product['category_id']);
        $categoryPath = $category['path'] ?? 'default';
        $folder = 'assets/SGV/Category/' . strtolower($categoryPath) . '/' . strtolower($product['slug']) . '/' . strtolower($variant['name']);
        $filePath = $folder . '/' . $img['image_path'];
        if (file_exists($filePath)) unlink($filePath); 
        $db->table('product_images')->delete(['id' => $img['id']]); 
    }
    $category = (new \App\Models\CategoryModel())->find($product['category_id']);
    $categoryPath = $category['path'] ?? 'default';
    $folder = 'assets/SGV/Category/' . strtolower($categoryPath) . '/' . strtolower($product['slug']) . '/' . strtolower($variant['name']);
    if (is_dir($folder) && count(scandir($folder)) === 2) { 
        rmdir($folder);
    }

    $variantModel->delete($id);

    return $this->response->setJSON(['success' => true]);
}

public function delete_variant_image($id)
{
    $db = \Config\Database::connect();
    $builder = $db->table('product_images');

    $image = $builder->getWhere(['id' => $id])->getRowArray();
    if (!$image) {
        return $this->response->setJSON(['success' => false, 'message' => 'Image not found']);
    }

    $variantModel = new \App\Models\ProductVariantModel();
    $variant = $variantModel->find($image['variant_id']);
    $productModel = new \App\Models\ProductModel();
    $product = $productModel->find($variant['product_id']);
    $category = (new \App\Models\CategoryModel())->find($product['id']);
    $categoryPath = $category['path'] ?? 'default';
    $folder = 'assets/SGV/Category/' . strtolower($categoryPath) . '/' . strtolower($product['slug']) . '/' . strtolower($variant['name']);
    $filePath = $folder . '/' . $image['image_path'];
    if (file_exists($filePath)) unlink($filePath);

    $builder->delete(['id' => $id]);

    return $this->response->setJSON(['success' => true]);
}

private function deleteFolderRecursive($folder)
{
    if (!is_dir($folder)) return;

    $files = array_diff(scandir($folder), ['.', '..']);
    foreach ($files as $file) {
        $path = $folder . '/' . $file;
        if (is_dir($path)) {
            $this->deleteFolderRecursive($path);
        } else {
            unlink($path);
        }
    }
    rmdir($folder);
}


  public function toggleDisplay($id)
    { 
    $productModel = new \App\Models\ProductModel();
    $db = \Config\Database::connect();
    $builder = $db->table('products');

    $data = [
        'is_display' => '0',
    ];
    $builder->update($data);
    $productModel->update($id, ['is_display' => 1]);

    return redirect()->to(site_url('admin/products'));
    }

    public function toggleSlide($id)
    { 
    $productModel = new \App\Models\ProductModel();
    
    $data = $productModel->find($id, ['is_show']);
    $isActive = $data['is_show'];
    if($isActive == 0){
    $productModel->update($id, ['is_show' => 1]);
    return redirect()->to(site_url('admin/products'));
    }else{
    $productModel->update($id, ['is_show' => 0]);
    return redirect()->to(site_url('admin/products'));
    }
    }


public function delete($id)
{
    $productModel = new \App\Models\ProductModel();
    $variantModel = new \App\Models\ProductVariantModel();
    $sectionModel = new \App\Models\ProductSectionModel();
    $db = \Config\Database::connect();

    $product = $productModel->find($id);
    if (!$product) {
        return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
    }

    $category = (new \App\Models\CategoryModel())->find($product['category_id']);
    $categoryPath = $category['path'] ?? 'default';
    $productFolder = 'assets/SGV/Category/' . strtolower($categoryPath) . '/' . strtolower($product['slug']);

    $variants = $variantModel->where('product_id', $id)->findAll();
    foreach ($variants as $variant) {
        $images = $db->table('product_images')->getWhere(['variant_id' => $variant['id']])->getResultArray();

        $variantFolder = $productFolder . '/' . strtolower($variant['name']);
        foreach ($images as $img) {
            $filePath = $variantFolder . '/' . $img['image_path'];
            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }
            $db->table('product_images')->delete(['id' => $img['id']]);
        }
        if (is_dir($variantFolder) && count(array_diff(scandir($variantFolder), ['.', '..'])) === 0) {
            rmdir($variantFolder);
        }

        $variantModel->delete($variant['id']);
    }

    $sections = $sectionModel->where('product_id', $id)->findAll();
    foreach ($sections as $section) {
        $sectionModel->delete($section['id']);
    }

    $mainImagePath = $productFolder . '/' . $product['main_images'];
    if (!empty($product['main_images']) && file_exists($mainImagePath) && is_file($mainImagePath)) {
        unlink($mainImagePath);
    }

    if (is_dir($productFolder) && count(array_diff(scandir($productFolder), ['.', '..'])) === 0) {
        rmdir($productFolder);
    }

    $productModel->delete($id);

    return redirect()->to('/admin/products')->with('success', 'Produk beserta semua data terkait berhasil dihapus.');
}


}