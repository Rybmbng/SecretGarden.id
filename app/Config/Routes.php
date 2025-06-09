<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('products', 'ProductController::index');           
$routes->get('category/(:segment)', 'CategoryController::index/$1');
$routes->get('products/(:segment)', 'ProductController::detail/$1');
$routes->get('brand', 'BrandController::index');
