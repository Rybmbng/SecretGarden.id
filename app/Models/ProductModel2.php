<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'slug', 'description', 'price', 'image_url', 'category'];

    public function getAllProducts()
    {
        return $this->findAll();
    }

    public function getCategories()
    {
        return $this->select('category')->distinct()->findAll();
    }

    public function getProductsByCategory($category)
    {
        return $this->where('category', $category)->findAll();
    }

    public function getProductBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
}
