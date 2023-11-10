<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index', ['as' => 'home.index']);

$routes->get('/patient', 'PatientController::index', ['as' => 'patient.index']);

service('auth')->routes($routes);
