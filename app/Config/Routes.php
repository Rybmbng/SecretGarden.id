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
$routes->get('category/(:segment)', 'CategoryController::index/$1');        
$routes->get('products/(:segment)', 'ProductController::detail/$1');
$routes->get('cart', 'Cart::index');
$routes->get('cart/add/(:any)', 'Cart::add/$1');
$routes->get('cart/min/(:any)', 'Cart::min/$1');
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->get('brand', 'BrandController::index');


//user Route
$routes->get('profile', 'ProfileController::index');

//admin Route
$routes->group('admin', ['filter' => 'rolecheck'], function($routes) {
    $routes->get('/', 'Admin\HomeController::index');
});