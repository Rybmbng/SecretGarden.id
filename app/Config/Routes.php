<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===================
//  USER Routes 
// ===================

$routes->get('/', 'HomeController::index');

$routes->get('/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

$routes->get('products', 'ProductController::index');   
$routes->get('products/(:segment)', 'ProductController::detail/$1');

$routes->get('brand', 'BrandController::index');

$routes->get('category', 'CategoryController::index');        
$routes->get('category/(:segment)', 'CategoryController::detail/$1');

$routes->get('services', 'HomeController::index');
$routes->get('services/cu', 'ServiceController::cu');
$routes->get('services/cg', 'ServiceController::cg');

$routes->get('findus', 'FindusController::index');

$routes->get('search', 'SearchController::suggestion');
$routes->get('search/suggestion', 'SearchController::suggestion');

$routes->get('cart', 'CartController::index');
$routes->get('cart/add/(:num)/(:num)', 'CartController::add/$1/$2');
$routes->get('cart/min/(:num)', 'CartController::min/$1');
$routes->get('cart/remove/(:any)', 'CartController::remove/$1');

$routes->get('profile', 'ProfileController::index');;
$routes->get('profile/(:segment)', 'ProfileController::index/$1');
$routes->post('profile/update/(:segment)', 'ProfileController::update/$1');

// ===================
//  ADMIN Routes
// ===================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'HomeAdminController::index');
    // Product Management
    $routes->group('products', function($routes) {
    $routes->get('/', 'ProductAdminController::index'); 
    $routes->get('create', 'ProductAdminController::create');
    $routes->post('store', 'ProductAdminController::store'); 
    $routes->get('edit/(:num)', 'ProductAdminController::edit/$1'); 
    $routes->post('update/(:num)', 'ProductAdminController::update/$1'); 
    $routes->post('delete/(:num)', 'ProductAdminController::delete/$1'); 
    $routes->get('show/(:num)', 'ProductAdminController::show/$1'); 
    });

    // Category Management
    $routes->get('categories', 'CategoryAdminController::index');
    $routes->get('categories/create', 'CategoryAdminController::create');
    $routes->post('categories/store', 'CategoryAdminController::store');
    $routes->get('categories/edit/(:num)', 'CategoryAdminController::edit/$1');
    $routes->post('categories/update/(:num)', 'CategoryAdminController::update/$1');
    $routes->get('categories/delete/(:num)', 'CategoryAdminController::delete/$1');

    // User Management
    $routes->get('users', 'UserManAdminController::index');
    $routes->get('users/create', 'UserManAdminController::create');
    $routes->post('users/store', 'UserManAdminController::store');
    $routes->get('users/edit/(:num)', 'UserManAdminController::edit/$1');
    $routes->post('users/update/(:num)', 'UserManAdminController::update/$1');
    $routes->get('users/delete/(:num)', 'UserManAdminController::delete/$1');
});
