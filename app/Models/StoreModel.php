<?php
namespace App\Models;
use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'address', 'phone', 'open_hours', 'map_embed'];
}
