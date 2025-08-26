<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\ProfileModel;

class UserManAdminController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $data['users'] = $userModel->findAll();
        $data['roles'] = $roleModel->findAll();
        $data['pageTitle'] = 'Users Management';

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $userModel = new UserModel();

        $userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role_id'  => $this->request->getPost('role_id'),
            'is_active'=> $this->request->getPost('is_active') ? 1 : 0,
        ]);
        return redirect()->to(base_url('admin/users'));
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to(base_url('admin/users'));
    }
}
