<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\RoleModel;
use App\Models\RoleMenuModel;

class MenuController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        $roleModel = new RoleModel();

        $data['menus'] = $menuModel->findAll();
        $data['roles'] = $roleModel->findAll();

        return view('admin/menu/index', $data);
    }

    public function create()
    {
        $menuModel = new MenuModel();
        $menuModel->save([
            'name' => $this->request->getPost('name'),
            'url' => $this->request->getPost('url'),
            'icon' => $this->request->getPost('icon'),
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);
        return redirect()->to('/admin/menu');
    }

    public function delete($id)
    {
        $menuModel = new MenuModel();
        $menuModel->delete($id);
        return redirect()->to('/admin/menu');
    }

    public function setRoleAccess()
    {
        $roleId = $this->request->getPost('role_id');
        $menuIds = $this->request->getPost('menu_ids') ?? [];

        $roleMenuModel = new RoleMenuModel();
        $roleMenuModel->where('role_id', $roleId)->delete();

        foreach ($menuIds as $menuId) {
            $roleMenuModel->insert([
                'role_id' => $roleId,
                'menu_id' => $menuId
            ]);
        }

        return redirect()->to('/admin/menu');
    }
}
