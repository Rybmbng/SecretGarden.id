<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===================
//  USER Routes 
// ===================

$routes->get('/', 'HomeController::index');

$routes->post('auth/login', 'Auth::login');
$routes->post('auth/register', 'Auth::register');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/delete/(:num)', 'Auth::delete/$1');
$routes->post('auth/store', 'Auth::store');
$routes->get('auth/check-identity', 'Auth::checkIdentity');


$routes->post('chat/ai', 'ChatController::reply');

$routes->get('products', 'ProductController::index');   
$routes->get('products/(:segment)', 'ProductController::detail/$1');

$routes->get('brand', 'BrandController::index');

$routes->get('category', 'CategoryController::index');        
$routes->get('category/(:segment)', 'CategoryController::detail/$1');

$routes->get('services', 'HomeController::index');

$routes->get('services/contactus', 'ContactController::index');
// $routes->post('services/contactus/send', 'ContactController::send');
$routes->get('services/contactus/send', 'ContactController::send');

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

    $routes->group('products', function($routes) {
    $routes->get('/', 'ProductAdminController::index'); 
    $routes->get('create', 'ProductAdminController::create');
    $routes->post('store', 'ProductAdminController::store'); 
    $routes->post('toggle-display/(:num)', 'ProductAdminController::toggleDisplay/$1'); 
    $routes->post('toggle-slide/(:num)', 'ProductAdminController::toggleSlide/$1'); 
    $routes->get('edit/(:num)', 'ProductAdminController::edit/$1'); 
    $routes->post('update/(:num)', 'ProductAdminController::update/$1'); 
    $routes->post('delete/(:num)', 'ProductAdminController::delete/$1'); 
    $routes->get('show/(:num)', 'ProductAdminController::show/$1'); 
    $routes->delete('delete-variant-image/(:num)', 'ProductAdminController::delete_variant_image/$1');
    $routes->delete('delete-variant/(:num)', 'ProductAdminController::delete_variant/$1');
    $routes->delete('delete-variant-image/(:num)', 'ProductAdminController::delete_variant_image/$1');
  
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
    $routes->post('users/create', 'UserManAdminController::create');
    $routes->get('users/edit/(:num)', 'UserManAdminController::edit/$1');
    $routes->post('users/update/(:num)', 'UserManAdminController::update/$1');
    $routes->get('users/delete/(:num)', 'UserManAdminController::delete/$1');

    // Role Management
    $routes->get('roles', 'RoleController::index');
    $routes->post('roles/create', 'RoleController::create');
    $routes->get('roles/delete/(:num)', 'RoleController::delete/$1');
    
    // menu Management
    $routes->get('menu', 'MenuController::index');
    $routes->post('menu/create', 'MenuController::create');
    $routes->get('menu/delete/(:num)', 'MenuController::delete/$1');
    $routes->post('menu/setRoleAccess', 'MenuController::setRoleAccess');
    
    // Company Management
    $routes->get('setting/company', 'CompanyController::index');
    $routes->post('setting/company/update', 'CompanyController::update');

    // Footer Management
    $routes->get('setting/footer', 'FooterController::index');
    $routes->post('setting/footer/create', 'FooterController::create');

    // Mail Management
    $routes->get('setting/email', 'EmailConfigController::index');
    $routes->post('setting/email/update', 'EmailConfigController::update');


    // Page Management
    
    // Brand Management
    $routes->get('page/brand', 'BrandController::index');
    $routes->get('page/brand/create', 'BrandController::create');
    $routes->get('page/brand/edit/(:num)', 'BrandController::edit/$1');
    $routes->post('page/brand/store', 'BrandController::store');
    $routes->post('page/brand/update/(:num)', 'BrandController::update/$1');
    $routes->get('page/brand/delete/(:num)', 'BrandController::delete/$1');

    // Findus Management
    $routes->get('page/findus', 'FindusController::index');
    $routes->get('page/findus/create', 'FindusController::create');
    $routes->get('page/findus/edit/(:num)', 'FindusController::edit/$1');
    $routes->post('page/findus/store', 'FindusController::store');
    $routes->post('page/findus/update/(:num)', 'FindusController::update/$1');
    $routes->get('page/findus/delete/(:num)', 'FindusController::delete/$1');
});