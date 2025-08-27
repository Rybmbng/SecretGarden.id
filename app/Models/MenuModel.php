<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuModel extends Model {
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','url','icon','parent_id','order','is_active'];

   public function getMenuTree($menus = null, $parentId = null)
    {
        if ($menus === null) {
            $menus = $this->orderBy('parent_id','ASC')->orderBy('order','ASC')->findAll();
        }

        $tree = [];
        foreach($menus as $menu){
            if($menu['parent_id'] == $parentId){
                $children = $this->getMenuTree($menus, $menu['id']);
                if($children){
                    $menu['children'] = $children;
                }
                $tree[] = $menu;
            }
        }
        return $tree;
    }

}
