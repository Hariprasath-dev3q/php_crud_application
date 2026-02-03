<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/home', 'Home::index');
// $routes->post('home/save-items', 'Home::saveItems');
// $routes->get('display', 'Home::getItems');
// $routes->get('home/(:num)', "Home::editItem/$1");
// $routes->get('delete-item/(:num)', "Home::deleteItem/$1");


$routes->group('home', function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->post('save-items', 'Home::saveItems');
    $routes->get('display', 'Home::getItems');
    $routes->get('(:num)', 'Home::editItem/$1');
    $routes->post('delete-item', 'Home::deleteItem');
});

$routes->post('export-excel', 'Home::exportData');
