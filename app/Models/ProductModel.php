<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'name', 'slug', 'price', 'image', 'description'];

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
}
