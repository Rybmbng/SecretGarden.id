<?php
use App\Models\MenuModel;

if (! function_exists('getSidebarMenu')) {
    function getSidebarMenu($roleId)
    {
        $menuModel = new MenuModel();
        $menus = $menuModel->select('menus.*')
            ->join('role_menu', 'role_menu.menu_id = menus.id')
            ->where('role_menu.role_id', $roleId)
            ->where('menus.is_active', 1)
            ->orderBy('menus.parent_id','ASC')
            ->orderBy('menus.order','ASC')
            ->findAll();
        return buildMenuTree($menus);
    }

    function buildMenuTree(array $menus, $parentId = null)
    {
        $tree = [];
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parentId) {
                $children = buildMenuTree($menus, $menu['id']);
                if ($children) {
                    $menu['children'] = $children;
                }
                $tree[] = $menu;
            }
        }
        return $tree;
    }
}
