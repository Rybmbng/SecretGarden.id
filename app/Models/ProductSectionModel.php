<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductSectionModel extends Model
{
    protected $table = 'product_sections';
    protected $allowedFields = ['product_id', 'type', 'header', 'created_at', 'updated_at'];
    protected $useTimestamps = false;

}
