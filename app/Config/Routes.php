<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //home routes
$routes->get('/', 'HomeController::index');

// login routes
$routes->get('/login', 'LogNRegController::index');
$routes->post('/login', 'LogNRegController::login');
$routes->post('/auth/login', 'Auth::doLogin');
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password', 'Auth::doForgotPassword');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// product routes
$routes->get('products', 'ProductController::index');           
$routes->get('products/(:segment)', 'ProductController::detail/$1');

// category and brand routes
$routes->get('category/(:segment)', 'CategoryController::index/$1');


// brand routes
$routes->get('brand', 'BrandController::index');


// profile routes
$routes->get('profile', 'ProfileController::index');
