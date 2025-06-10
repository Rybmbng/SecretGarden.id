<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    function getUserProfileData(){
        // This function should return user profile data
        // For example, it could fetch data from a model or database
        return [
            'username' => 'JohnDoe',
            'email' => 'reyvans.pahlevi04@gmail.com',
            'bio' => 'This is a short bio about the user.',
            'profile_picture' => 'https://ui-avatars.com/api/?name=John+Doe&background=34d399&color=fff',
            'created_at' => '2023-10-01',
            'updated_at' => '2023-10-10',
            'social_links' => [
                'facebook' => 'https://facebook.com/johndoe',
                'twitter' => 'https://twitter.com/johndoe',
                'instagram' => 'https://instagram.com/johndoe',
                'linkedin' => 'https://linkedin.com/in/johndoe',
                'github' => 'https://github.com/johndoe'
            ]
        ];
    }
    public function index()
    {
        // Logic to retrieve user profile data
        // This could involve fetching data from a model or database
        $data = [
            'title' => 'User Profile',
            'user' => $this->getUserProfileData(), 
        ];

        // Load the profile view and pass the data
        return view('profile', $data);
    }
}
