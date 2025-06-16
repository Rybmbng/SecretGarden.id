<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
class ProfileController extends BaseController
{
    function getUserProfileData(){

    $userModel =  new UserModel();
    
    $userData = $userModel -> findall();
    return $userData;
    
    }
    public function index()
    {     
    $user = session()->get('user');
    if (!$user) {
        return view('login');
    }else{

        $data = [
            'title' => 'User Profile',
            'user' => $this->getUserProfileData(), 
        ];
        return view('profile', $data);
    }
}
}
