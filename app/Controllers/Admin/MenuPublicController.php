<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\MenuPublicModel;
use App\Models\RoleModel;
use App\Models\RoleMenuPublicModel;
use App\Models\ProductModel;

class MenuPublicController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuPublicModel();
        $roleModel = new RoleModel();
        $productModel = new ProductModel();

        $data['menus'] = $menuModel->orderBy('parent_id','ASC')->orderBy('order','ASC')->findAll();
        $data['roles'] = $roleModel->findAll();
        $data['products'] = $productModel->orderBy('name','ASC')->findAll();
        $data['menuModel'] = $menuModel; 
        $data['pageTitle'] = "Menu Management"; 

        return view('/admin/setting/menupublic/index', $data);
    }

    public function create()
    {
        $menuModel = new MenuPublicModel();

        $childrenData = $this->request->getPost('children_data') ?? null;
        if($childrenData) {
            $childrenData = json_encode($childrenData);
        }

        $menuModel->save([
            'name' => $this->request->getPost('name'),
            'url' => $this->request->getPost('url'),
            'icon' => $this->request->getPost('icon'),
            'type' => $this->request->getPost('type'),
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'children_data' => $childrenData,
            'description' => $this->request->getPost('description') ?: null,
        ]);
        return redirect()->to('/admin/setting/menupublic');
    }

    public function update($id)
    {
        $menuModel = new MenuPublicModel();
        $data = $this->request->getPost();

        $childrenData = $data['children_data'] ?? null;
        if($childrenData) {
            $childrenData = json_encode($childrenData);
        }

        $menuModel->update($id, [
            'name' => $data['name'],
            'url' => $data['url'],
            'icon' => $data['icon'],
            'type' => $data['type'],
            'parent_id' => $data['parent_id'] ?: null,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'children_data' => $childrenData,
            'description' => $data['description'] ?? null,
        ]);

        $updatedMenu = $menuModel->find($id);

        return $this->response->setJSON([
            'success' => true,
            'menu' => $updatedMenu
        ]);
    }

    public function delete($id)
    {
        $menuModel = new MenuPublicModel();
        $menuModel->delete($id);
        return redirect()->to('/admin/setting/menupublic');
    }

    public function setRoleAccess()
    {
        $roleId = $this->request->getPost('role_id');
        $menuIds = $this->request->getPost('menu_ids') ?? [];

        $roleMenuModel = new RoleMenuPublicModel();
        $roleMenuModel->where('role_id', $roleId)->delete();

        foreach ($menuIds as $menuId) {
            $roleMenuModel->insert([
                'role_id' => $roleId,
                'menu_id' => $menuId
            ]);
        }

        return redirect()->to('/admin/setting/menupublic');
    }
}
