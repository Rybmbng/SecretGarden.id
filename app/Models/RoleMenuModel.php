<?php
namespace App\Models;
use CodeIgniter\Model;

class RoleMenuModel extends Model {
    protected $table = 'role_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id','menu_id'];
}
