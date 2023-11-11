<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * Home Routes
 */
$routes->get('/', 'HomeController::index', ['as' => 'home.index']);

/**
 * Patient Routes
 */
$routes->get('/patient', 'PatientController::index', ['as' => 'patient.index']);
$routes->get('/patient/create', 'PatientController::create', ['as' => 'patient.create']);
$routes->post('/patient', 'PatientController::store', ['as' => 'patient.store']);
$routes->get('/patient/(:num)/edit', 'PatientController::edit/$1', ['as' => 'patient.edit']);
$routes->match(['put', 'patch'], '/patient/(:num)', 'PatientController::update/$1', ['as' => 'patient.update']);
$routes->delete('/patient/(:num)', 'PatientController::destroy/$1', ['as' => 'patient.destroy']);

service('auth')->routes($routes);
