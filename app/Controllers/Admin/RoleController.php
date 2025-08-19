<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class RoleController extends BaseController
{
     protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();
        return view('admin/roles/index', $data);
    }

    public function create()
    {
        $id=$this->request->getPost('id');
        if($id == 0){
        return redirect()->to(base_url('admin/roles'));
        }
        
        $roleModel = new RoleModel();
        $roleModel->insert([
            'id' => $this->request->getPost('id'),
            'role_name' => $this->request->getPost('role_names'),
        ]);

        return redirect()->to(base_url('admin/roles'));
    }

    public function delete($id)
    {
        $roleModel = new RoleModel();
        $roleModel->delete($id);
        return redirect()->to(base_url('admin/roles'));
    }
}
