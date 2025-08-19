<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuModel extends Model {
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','url','icon','parent_id','is_active'];
}
