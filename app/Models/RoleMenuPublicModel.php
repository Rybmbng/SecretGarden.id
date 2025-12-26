<?php
namespace App\Models;
use CodeIgniter\Model;

class RoleMenuPublicModel extends Model {
    protected $table = 'role_menu_public';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id','menu_id'];
}
