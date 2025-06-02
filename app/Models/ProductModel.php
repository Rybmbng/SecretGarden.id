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
    public function getAllCategories()
    {
        return $this->distinct()->select('category')->orderBy('category')->findColumn('category');
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
    public function getPrevProduct($currentId, $category)
{
    return $this->where('category', $category)
                ->where('id <', $currentId)
                ->orderBy('id', 'DESC')
                ->first();
}

public function getNextProduct($currentId, $category)
{
    return $this->where('category', $category)
                ->where('id >', $currentId)
                ->orderBy('id', 'ASC')
                ->first();
}

public function getRelatedProducts($category, $excludeId, $limit = 4)
{
    return $this->where('category', $category)
                ->where('id !=', $excludeId)
                ->orderBy('id', 'DESC')
                ->limit($limit)
                ->findAll();
}


}
