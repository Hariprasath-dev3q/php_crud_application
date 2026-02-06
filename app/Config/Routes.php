<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;

/**
 * @var RouteCollection $routes
 */



$routes->group('studentform', function ($routes) {
    $routes->get('/', 'StudentForm::index');
    $routes->post('save-items', 'StudentForm::saveItems');
    $routes->get('display', 'StudentForm::getItems');
    $routes->get('(:num)', 'StudentForm::editItem/$1');
    $routes->post('delete-item', 'StudentForm::deleteItem');
});

$routes->group('insertData', function ($routes) {
    $routes->get('display', 'InsertData::displayStudentDetails');
    $routes->post('import-excel', 'InsertData::importExcel');
    $routes->post('export-excel', 'InsertData::exportData');
    $routes->post('sample-excel', 'InsertData::sampleExcel');
    $routes->post('delete-multiple', 'InsertData::deleteMultiple');
});





// $routes->get('news/import-json', 'Home::importJson');
