<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===================
//  USER Routes
// ===================

$routes->get('/', 'HomeController::index');

$routes->get('notifications/getNotifications', 'NotificationController::getNotifications');
$routes->post('notifications/markAsRead/(:num)', 'NotificationController::markAsRead/$1');

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
$routes->post('services/contactus/send', 'ContactController::send');

$routes->get('services/cg', 'ServiceController::cg');

$routes->get('findus', 'StoreController::index');
$routes->get('findus/(:any)', 'StoreController::detail/$1');

$routes->get('search', 'SearchController::suggestion');
$routes->get('search/suggestion', 'SearchController::suggestion');

$routes->get('cart', 'CartController::index');
$routes->get('cart/add/(:num)/(:num)', 'CartController::add/$1/$2');
$routes->get('cart/min/(:num)', 'CartController::min/$1');
$routes->get('cart/remove/(:any)', 'CartController::remove/$1');

$routes->get('profile', 'ProfileController::index');;
$routes->get('profile/(:segment)', 'ProfileController::index/$1');
$routes->post('profile/update', 'ProfileController::update');

$routes->get('page/(:segment)', 'PageController::view/$1');

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
    $routes->post('setting/email/save', 'EmailConfigController::save');
    $routes->post('setting/email/test', 'EmailConfigController::testConnection');
    $routes->post('setting/email/test/imap', 'EmailConfigController::testImap');
    $routes->post('setting/email/test/smtp', 'EmailConfigController::testSmtp');
    $routes->post('setting/email/test/smtp-connection', 'EmailConfigController::testSmtpConnection');

    // Group admin email
    $routes->group('email', ['namespace' => 'App\Controllers\Admin'], function($routes) {
        $routes->get('sync', 'EmailController::sync');
        $routes->get('inbox', 'EmailController::inbox');
        $routes->get('view/(:num)', 'EmailController::view/$1');
        $routes->get('reply/(:num)', 'EmailController::reply/$1');
        $routes->post('reply/(:num)', 'EmailController::sendReply/$1');
        $routes->get('forward/(:num)', 'EmailController::forward/$1');
        $routes->post('forward/(:num)', 'EmailController::sendForward/$1');
        $routes->get('compose', 'EmailController::compose');
        $routes->get('download/(:num)', 'EmailController::download/$1');
        $routes->post('send', 'EmailController::send');
    });

    // Page Management
    $routes->group('page', ['namespace' => 'App\Controllers\Admin'], function($routes) {

    // Brand Management
    $routes->get('brand', 'BrandController::index');
    $routes->get('brand/create', 'BrandController::create');
    $routes->get('brand/edit/(:num)', 'BrandController::edit/$1');
    $routes->post('brand/store', 'BrandController::store');
    $routes->post('brand/update/(:num)', 'BrandController::update/$1');
    $routes->get('brand/delete/(:num)', 'BrandController::delete/$1');

    // Findus Management
    $routes->get('stores', 'StoreController::index');
    $routes->get('stores/create', 'StoreController::create');
    $routes->post('stores/store', 'StoreController::store');
    $routes->get('stores/edit/(:num)', 'StoreController::edit/$1');
    $routes->post('stores/update/(:num)', 'StoreController::update/$1');
    $routes->get('stores/delete/(:num)', 'StoreController::delete/$1');

    //Home Management
    $routes->group('home', ['namespace' => 'App\Controllers\Admin'], function($routes) {
        $routes->get('/', 'HomeAdminController::index');
        $routes->get('slider/create', 'HomeAdminController::createSlider');
        $routes->get('slider/edit/(:num)', 'HomeAdminController::editSlider/$1');
        $routes->post('slider/store', 'HomeAdminController::storeSlider');
        $routes->post('slider/update/(:num)', 'HomeAdminController::updateSlider/$1');
        $routes->get('slider/delete/(:num)', 'HomeAdminController::deleteSlider/$1');
        });
    });


    //POST
    $routes->group('cms', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'CmsPageController::index');
    $routes->get('create', 'CmsPageController::create');
    $routes->post('store', 'CmsPageController::store');
    $routes->get('edit/(:num)', 'CmsPageController::edit/$1');
    $routes->post('update/(:num)', 'CmsPageController::update/$1');
    $routes->get('delete/(:num)', 'CmsPageController::delete/$1');
});
});