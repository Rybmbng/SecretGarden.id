<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuPublicModel extends Model {
    protected $table = 'menus_public';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','url','icon','parent_id','order','is_active','type','description','children_data'];

   public function getMenuTree($menus = null, $parentId = null)
{
    if ($menus === null) {
        $menus = $this->orderBy('parent_id','ASC')
                      ->orderBy('order','ASC')
                      ->findAll();
    }

    $tree = [];
    foreach($menus as $menu){
        if($menu['parent_id'] == $parentId){

            $children = $this->getMenuTree($menus, $menu['id']);
            if ($menu['type'] === 'post') {
                $db = db_connect();
                $children = $db->table('posts')
                               ->select('id, title as name, slug as url')
                               ->orderBy('created_at','DESC')
                               ->limit(5)
                               ->get()->getResultArray();
            }

            if ($menu['type'] === 'product') {
                $db = db_connect();
                $children = $db->table('products')
                               ->select('id, name, slug as url')
                               ->orderBy('views','DESC')
                               ->limit(5)
                               ->get()->getResultArray();
            }

            if($children){
                $menu['children'] = $children;
            }
            $tree[] = $menu;
        }
    }
    return $tree;
}


}
