<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //home routes
$routes->get('/', 'HomeController::index');

// login routes
$routes->get('/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');


// product routes
$routes->get('products', 'ProductController::index');           
$routes->get('products/(:segment)', 'ProductController::detail/$1');

// category and brand routes
$routes->get('category/(:segment)', 'CategoryController::index/$1');


$routes->get('brand', 'BrandController::index');


$routes->get('profile', 'ProfileController::index');


$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->get('products', 'Admin/AdminController::products');
    $routes->get('categories', 'Admin/AdminController::categories');
});
