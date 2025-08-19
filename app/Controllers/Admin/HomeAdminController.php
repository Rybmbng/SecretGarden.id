<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ActivityModel;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class HomeAdminController extends BaseController
{
    

    public function index()
    {
            // Load models
            $activityModel = new ActivityModel();
            $userModel = new UserModel();
            $productModel = new ProductModel();
            $categoryModel = new CategoryModel();

            // Fetch total counts
            $totalProducts = $productModel->countAll();
            $totalCategories = $categoryModel->countAll();
            $totalUsers = $userModel->countAll();

            $recentActivities = $activityModel->getRecentActivities() ?? [];
           
         return view('admin/index', [
             'pageTitle' => 'Admin Dashboard',
             'totalProducts' => $totalProducts,
             'totalCategories' => $totalCategories,
             'totalUsers' => $totalUsers,
             'recentActivities' => $recentActivities,
         ]);
        

    }

    public function config(){
        return view('admin/home');
    }

    public function slider(){
        return view('admin/home/slider');
    }

}

    
