<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FindusController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Find Us',
            'metaDescription' => 'Find us at SecretGarden.id, your destination for unique gifts and services.',
            'metaKeywords' => 'find us, contact, location, SecretGarden.id',
        ];

        return view('findus/index', $data);
    }
}
