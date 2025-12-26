<?php
use App\Models\MenuPublicModel;

if (! function_exists('getSidebarMenuPublic')) {

    /**
     * Ambil semua menu public
     */
    function getSidebarMenuPublic()
    {
        $menuModel = new MenuPublicModel();
        $menus = $menuModel->where('is_active', 1)
            ->orderBy('parent_id', 'ASC')
            ->orderBy('order', 'ASC')
            ->findAll();

        return buildMenuTreePublic($menus);
    }

    /**
     * Build menu tree recursive
     */
    function buildMenuTreePublic(array $menus, $parentId = null)
    {
        $tree = [];
        $db = db_connect();

        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parentId) {

                // Ambil anak recursive
                $childrenMenu = buildMenuTreePublic($menus, $menu['id']);

                // Ambil dynamic children (post/product) dari children_data
                $dynamicChildren = [];

                if ($menu['type'] === 'post') {
                    $posts = json_decode($menu['children_data'] ?? '[]', true) ?: [];
                    foreach($posts as $child){
                        $dynamicChildren[] = [
                            'id' => 0,
                            'name' => $child['title'] ?? 'Untitled',
                            'url' => $child['url'] ?? '#',
                            'type' => 'post',
                            'parent_id' => $menu['id'],
                            'is_active' => 1
                        ];
                    }
                }

                if ($menu['type'] === 'product') {
                    $productIds = json_decode($menu['children_data'] ?? '[]', true) ?: [];
                    if (!empty($productIds)) {
                        $products = $db->table('products')
                            ->select('products.id as id, products.slug as slug, products.name as name, products.main_images as main_images, categories.name as catname')
                            ->join('categories', 'categories.id = products.category_id', 'left')
                            ->whereIn('products.id', $productIds)
                            ->orderBy('products.created_at','DESC')
                            ->get()
                            ->getResultArray();

                        foreach($products as $prod) {
                            $dynamicChildren[] = [
                                'id' => 0,
                                'name' => $prod['name'],
                                'url' => $prod['slug'],
                                'type' => 'product',
                                'main_images' => $prod['main_images'] ?? 'noimg.jpg',
                                'catname' => $prod['catname'] ?? '',
                                'parent_id' => $menu['id'],
                                'is_active' => 1
                            ];
                        }
                    }
                }

                // Gabungkan semua children
                $allChildren = array_merge($childrenMenu, $dynamicChildren);

                if (!empty($allChildren)) {
                    $menu['children'] = $allChildren;
                }

                $tree[] = $menu;
            }
        }

        return $tree;
    }
}
