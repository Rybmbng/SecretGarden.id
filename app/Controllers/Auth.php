<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfileModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
       $session = session();
        $model = new UserModel();

        $identity = $this->request->getPost('usermail');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $identity)
                    ->orWhere('username', $identity)
                    ->first();
        if ($user && password_verify($password, $user['password'])) {
              session()->set('user', [
                'isLoggedIn' => true,
                'id_user' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role_id' => $user['role_id']
            ]);
            if ($user['role_id'] != 2 || $user['role_id'] != '') {
                    return redirect()->to(base_url('admin'));
            } else {
                return redirect()->to('/');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah');
    }

    public function register()
    {
        $userModel = new UserModel();
        $profileModel = new ProfileModel();

        $userId = $userModel->insert([
            'username'    => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        $profileModel->insert([
            'id_user'    => $userId,
            'name'       => $this->request->getPost('name'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
            'location'   => $this->request->getPost('location'),
            'birthday'   => $this->request->getPost('birthday'),
            'bio'        => $this->request->getPost('bio'),
            'avatar'     => null,
            'cover_photo'=> null,
        ]);

        return redirect()->to('/profile')->with('success','Registrasi berhasil, silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/profile');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/users')->with('success', 'User berhasil dihapus');
    }

    public function store()
    {
        $model = new UserModel();
        $data = $this->request->getPost();

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $model->insert($data);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function checkIdentity()
{
    $model = new UserModel();
    $type  = $this->request->getGet('type');
    $value = $this->request->getGet('value');

    if ($type === 'email') {
        $exists = $model->where('email', $value)->first();
    } elseif ($type === 'username') {
        $exists = $model->where('username', $value)->first();
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid type']);
    }

    return $this->response->setJSON(['exists' => $exists ? true : false]);
}

}