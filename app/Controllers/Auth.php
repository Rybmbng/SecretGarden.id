<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        
        return view('login', [
            'pageTitle' => 'Login Page',
        ]);
    }

    public function register()
    {
        return view('login', [
            'pageTitle' => 'Register Page',
        ]);
    }

    public function doRegister()
    {
        $userModel = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user'
            
        ];
        $userModel->save($data);
        return redirect()->to('/login');
    }

    public function doLogin()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $userModel->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            session()->set('user', [
                'isLoggedIn' => true,
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role']
            ]);
            
            if ($user['role'] == 'admin') {
                    return redirect()->to(base_url('admin'));
            } else {
                return redirect()->to('/');
            }

        }

        return redirect()->back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
