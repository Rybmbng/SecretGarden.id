<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');


$routes->get('products', 'ProductController::index');   
$routes->get('products/(:segment)', 'ProductController::detail/$1');
$routes->get('cart', 'CartController::index');
$routes->get('cart/add/(:num)/(:num)', 'CartController::add/$1/$2');
$routes->get('cart/min/(:num)/(:num)', 'CartController::min/$1/&2');
$routes->get('cart/remove/(:any)', 'CartController::remove/$1');
$routes->get('brand', 'BrandController::index');

$routes->get('category/', 'CategoryController::index');        
$routes->get('category/(:segment)', 'CategoryController::detail/$1');        


//user Route
$routes->get('profile', 'ProfileController::index');

//adm   in Route
$routes->get('admin', 'Admin\HomeAdminController::index');

$routes->group('admin/products', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'ProductAdminController::index'); 
    $routes->get('create', 'ProductAdminController::create');
    $routes->post('store', 'ProductAdminController::store'); 
    $routes->get('edit/(:num)', 'ProductAdminController::edit/$1'); 
    $routes->post('update/(:num)', 'ProductAdminController::update/$1'); 
    $routes->post('delete/(:num)', 'ProductAdminController::delete/$1'); 
    $routes->get('show/(:num)', 'ProductAdminController::show/$1'); 
});


$routes->get('admin/categories', 'Admin\CategoryAdminController::index');
$routes->get('admin/categories/create', 'Admin\CategoryAdminController::create');
$routes->post('admin/categories/store', 'Admin\CategoryAdminController::store');
$routes->get('admin/categories/edit/(:num)', 'Admin\CategoryAdminController::edit/$1');
$routes->post('admin/categories/update/(:num)', 'Admin\CategoryAdminController::update/$1');
$routes->get('admin/categories/delete/(:num)', 'Admin\CategoryAdminController::delete/$1');
$routes->get('admin/categories/admin/users', 'Admin\UserManAdminController::index', ['filter' => 'rolecheck']);

//services
$routes->get('services', 'ServiceController::index');
$routes->get('services/cu', 'ServiceController::index');
$routes->get('services/cg', 'ServiceController::index');