<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $allowedFields = ['name', 'parent_id', 'type'];

    public function getCategoryTree($parent_id = null)
    {
        $result = $this->where('parent_id', $parent_id)->findAll();

        foreach ($result as &$row) {
            $row['children'] = $this->getCategoryTree($row['id']);
        }

        return $result;
    }
}
