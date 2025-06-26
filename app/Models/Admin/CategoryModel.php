<?php namespace App\Models\Admin;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useTimestamps = false; 
    protected $allowedFields = ['name', 'img', 'description', 'path','status'];

    
}
