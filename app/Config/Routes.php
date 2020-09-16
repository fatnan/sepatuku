<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
// $routes->get('/', 'Home::index2');

$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');


//sepatu
$routes->get('/sepatu', 'Sepatu::index');
$routes->get('/sepatu/create', 'Sepatu::create');
$routes->get('/sepatu/edit/(:segment)', 'Sepatu::edit/$1');
$routes->post('/sepatu/store','Sepatu::store');
$routes->delete('/sepatu/(:num)','Sepatu::delete/$1');
$routes->get('/sepatu/(:any)','Sepatu::detail/$1');

//sepatu masuk
$routes->get('/sepatumasuk', 'SepatuMasuk::index');
$routes->get('/sepatumasuk/create', 'SepatuMasuk::create');
$routes->get('/sepatumasuk/edit/(:segment)', 'SepatuMasuk::edit/$1');
$routes->post('/sepatumasuk/store','SepatuMasuk::store');
$routes->delete('/sepatumasuk/(:num)','SepatuMasuk::delete/$1');
$routes->get('/sepatumasuk/(:any)','SepatuMasuk::detail/$1');

//user
$routes->get('/user', 'User::index');
$routes->get('/user/create', 'User::create');
$routes->get('/user/edit/(:segment)', 'User::edit/$1');
$routes->post('/user/store','User::store');
$routes->delete('/user/delete/(:num)','User::delete/$1');
$routes->get('/user/(:any)','User::detail/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
