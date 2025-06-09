<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductSectionModel extends Model
{
    protected $table = 'product_sections';
    protected $allowedFields = ['product_id', 'type', 'header'];
}
