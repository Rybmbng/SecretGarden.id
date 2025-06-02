    <?php

    use CodeIgniter\Router\RouteCollection;

    /**
     * @var RouteCollection $routes
     */
    $routes->get('/', 'HomeController::index');
    
    $routes->get('products', 'ProductController::index');                     
    $routes->get('products/category/(:any)', 'ProductController::category/$1');
    $routes->get('products/(:segment)', 'ProductController::detail/$1');

    $routes->get('brand', 'BrandController::index');
