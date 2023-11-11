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

service('auth')->routes($routes);
