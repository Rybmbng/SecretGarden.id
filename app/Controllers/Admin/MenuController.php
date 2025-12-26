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
        $menuModel = new \App\Models\MenuModel();
        $roleModel = new \App\Models\RoleModel();

        $data['menus'] = $menuModel->orderBy('parent_id','ASC')->orderBy('order','ASC')->findAll();
        $data['roles'] = $roleModel->findAll();
        $data['menuModel'] = $menuModel; 
        $data['pageTitle'] = "Menu Management"; 

        return view('admin/setting/menu/index', $data);
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
        return redirect()->to('/admin/setting/menu');
    }
    public function update($id) {
        $menuModel = new \App\Models\MenuModel();
        $data = $this->request->getPost();

        $menuModel->update($id, [
            'name'      => $data['name'],
            'url'       => $data['url'],
            'icon'      => $data['icon'],
            'parent_id' => $data['parent_id'] ?: null,
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ]);

        // kembalikan data terbaru untuk JS
        $updatedMenu = $menuModel->find($id);

        return $this->response->setJSON([
            'success' => true,
            'menu'    => $updatedMenu
        ]);
    }
    public function delete($id)
    {
        $menuModel = new MenuModel();
        $menuModel->delete($id);
        return redirect()->to('/admin/setting/menu');
    }

    public function updateOrder()
    {
        $data = $this->request->getJSON();
        $menuModel = new MenuModel();
        foreach($data->order as $index => $id){
            $menuModel->update($id, ['order'=>$index]);
        }
        return $this->response->setJSON(['status'=>'success']);
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

        return redirect()->to('/admin/setting/menu');
    }
}
