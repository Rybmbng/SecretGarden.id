<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductSectionDetailModel extends Model
{
    protected $table = 'product_section_details';
    protected $allowedFields = ['section_id', 'detail'];
}
