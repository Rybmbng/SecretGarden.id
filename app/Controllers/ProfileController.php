<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\AddressModel;
class ProfileController extends BaseController
{
    function getUserProfileData(){
        $user = session()->get('user');
        if (!$user) {
            return null;
        }

        $userModel = new UserModel();

        $builder = $userModel->builder();
        $builder->select('users.*, profile.*, address.*');
        $builder->join('profile', 'profile.id_user = users.id', 'left');
        $builder->join('address', 'address.id_user = users.id', 'left');
        $builder->where('users.id', $user['id_user']);
        $query = $builder->get();
        return $query->getRowArray();
    
    }

    function getUserAddress(){
        $user = session()->get('user');
        if (!$user) {
            return null;
        }

        $addressModel = new AddressModel();

        $builder = $addressModel->builder();
        $builder->select('address.*');
        $builder->where('address.id_user', $user['id_user']);
        $builder->orderBy('address.address_id', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function index($slug = null)
    {     
        $user = session()->get('user');
        if (!$user) {
            return view('login', [
                'pageTitle' => 'Login',
                'error' => 'You must be logged in to view this page.'
            ]);
        } else {
            if ($slug != null) {
                if ($user['username'] != $slug) {
                    return redirect()->to(base_url('profile/' . $user['username']));
                }
                $data = [
                    'pageTitle' => 'Edit Profile',
                    'user' => $this->getUserProfileData(), 
                    'address' => $this->getUserAddress(),
                ];
                return view('profile/edit', $data);
            } else {
                $data = [
                    'pageTitle' => 'User Profile',
                    'user' => $this->getUserProfileData(), 
                    'address' => $this->getUserAddress(),

                ];
                return view('profile/index', $data);
            }
        }
    }

    
}
