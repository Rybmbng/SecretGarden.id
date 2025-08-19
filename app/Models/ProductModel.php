<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'name', 'slug', 'price', 'main_images', 'description','is_display','is_show', 'created_at', 'updated_at'];
    protected $useTimestamps = true; // kalau pakai created_at dan updated_at
    public function withRelations()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left');
    }

    public function getWithAllRelations($id)
    {
        $product = $this->withRelations()->find($id);

        if (!$product) return null;

        $variantModel = new ProductVariantModel();
        $imageModel = new ProductImageModel();
        $sectionModel = new ProductSectionModel();

        $product['variants'] = $variantModel->where('product_id', $id)->findAll();
        $product['images'] = $imageModel->where('product_id', $id)->findAll();
        $product['sections'] = $sectionModel->getWithDetailsByProduct($id);

        return $product;
    }
    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getByCategoryId($categoryId)
    {
        return $this->where('category_id', $categoryId)->findAll();
    }
      public function getProductBySlug($slug)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.slug', $slug)
            ->first();
    }

    public function sliderHome($num){
         return $this->select('products.name as pname, categories.name as cat_name, product_variants.name as variant_name, products.main_images as img')
            ->join('categories', 'categories.id = products.category_id')
            ->join('product_variants', 'products.id = product_variants.product_id')
            ->join('product_images', 'product_images.variant_id = product_variants.id')
            ->where('products.is_show', '1')
            ->groupBy('products.name')
            ->orderBy('products.name', 'DESC')
            ->limit($num)
            ->findAll();
            }
        
    public function mainProduct(){
        return $this->select('products.name as pname, categories.name as cat_name, product_variants.name as variant_name, products.main_images as img')
            ->join('categories', 'categories.id = products.category_id')
            ->join('product_variants', 'products.id = product_variants.product_id')
            ->where('products.is_display', '1')
            ->first();
        }

    public function search(){
        return $this->select('products.name as pname, categories.name as cat_name, product_variants.name as variant_name, product_images.image_path as img')
            ->join('categories', 'categories.id = products.category_id')
            ->join('product_variants', 'products.id = product_variants.product_id')
            ->join('product_images', 'products.id = product_images.product_id')
            ->first();
        }


   public function withCategory()
    {
    return $this->select('
            products.*,
            categories.name as category_name,
            categories.path as category_path,
            pv.name as variant_name,
            pi.image_path as image
        ')
        ->join('categories', 'categories.id = products.category_id', 'left')
        ->join('product_variants pv', 'pv.product_id = products.id AND pv.main = 1', 'left')
        ->join('product_images pi', 'pi.variant_id = pv.id AND pi.is_primary = 1', 'left');
    }


   
}


