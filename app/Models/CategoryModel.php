<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'description'];

    public function getCategoriesWithProducts()
{
    $builder = $this->db->table($this->table);
    $builder->select('
        categories.id as category_id, 
        categories.name as category_name, 
        categories.description, 
        products.id as product_id, 
        products.name as product_name, 
        products.price, 
        products.image as product_img
    ');
    $builder->join('products', 'products.category_id = categories.id', 'left');
    $query = $builder->get();
    $result = $query->getResultArray();

    $categories = [];
    foreach ($result as $row) {
        $catId = $row['category_id'];
        if (!isset($categories[$catId])) {
            $categories[$catId] = [
                'id' => $row['category_id'],
                'name' => $row['category_name'],
                'description' => $row['description'],
                'products' => [],
            ];
        }

        if ($row['product_id']) {
            $categories[$catId]['products'][] = [
                'id' => $row['product_id'],
                'name' => $row['product_name'],
                'price' => $row['price'],
                'img' => $row['product_img'], // tetap pakai 'img' agar kompatibel dengan view
            ];
        }
    }

    return array_values($categories);
}
public function getCategoryBySlug($slug)
{
    $builder = $this->db->table('categories');
    $builder->select('categories.*, products.id as product_id, products.name as product_name, products.slug as product_slug, products.price, products.img');
    $builder->join('products', 'products.category_id = categories.id', 'left');
    $builder->where('LOWER(REPLACE(categories.name, " ", "-"))', $slug);

    $query = $builder->get();
    $result = $query->getResultArray();

    if (empty($result)) return null;

    $category = [
        'name' => $result[0]['name'],
        'description' => $result[0]['description'],
        'products' => [],
    ];

    foreach ($result as $row) {
        if ($row['product_id']) {
            $category['products'][] = [
                'id' => $row['product_id'],
                'name' => $row['product_name'],
                'slug' => $row['product_slug'],
                'price' => $row['price'],
                'img' => $row['img'],
            ];
        }
    }

    return $category;
}

}
