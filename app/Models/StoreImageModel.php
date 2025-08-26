<?php
namespace App\Models;
use CodeIgniter\Model;

class StoreImageModel extends Model
{
    protected $table = 'store_images';
    protected $allowedFields = ['store_id', 'image'];
}
