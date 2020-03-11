<?php namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// --- Controllers/Home::class
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

// --- Controllers/Login::class
$routes->add('login', 'Login::index');

// --- Controllers/Project::class
$routes->add('project', 'Project::index');
$routes->add('project/(:num)/view', 'Project::view/$1');

// ---- Controllers/Admin
$routes->group(
    'admin',
    static function ($routes) {
        /** @var RouteCollection $routes */

        // --- Controllers/Admin/Project::class
        $routes->get('project', 'Admin\Project::index');
        $routes->get('project/create', 'Admin\Project::create');
        $routes->post('project/create', 'Admin\Project::create');
        $routes->get('project/edit/(:num)', 'Admin\Project::edit/$1');
        $routes->post('project/edit/(:num)', 'Admin\Project::edit/$1');
        $routes->get('project/delete/(:num)', 'Admin\Project::delete/$1');
        $routes->post('project/delete/(:num)', 'Admin\Project::delete/$1');
        $routes->get('project/managePermissions/(:num)', 'Admin\Project::managePermissions/$1');
        $routes->post('project/managePermissions/(:num)', 'Admin\Project::managePermissions/$1');

        // --- Controllers/Admin/User::class
        $routes->get('user', 'Admin\User::index');

        // --- Controllers/Admin/Group::class
        $routes->get('group', 'Admin\Group::index');
        $routes->get('group/assign/(:any)', 'Admin\Group::assign/$1'); // DEATH ROUTE!
        $routes->post('group/assign/(:any)', 'Admin\Group::assign/$1'); // DEATH ROUTE!

        // --- Controllers/Admin/role::class
        $routes->get('role', 'Admin\Role::index');
        $routes->get('role/create', 'Admin\Role::create');
        $routes->post('role/create', 'Admin\Role::create');
        $routes->get('role/edit/(:num)', 'Admin\Role::edit/$1');
        $routes->post('role/edit/(:num)', 'Admin\Role::edit/$1');
        $routes->get('role/delete/(:num)', 'Admin\Role::delete/$1');
        $routes->post('role/delete/(:num)', 'Admin\Role::delete/$1');
    }
);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}