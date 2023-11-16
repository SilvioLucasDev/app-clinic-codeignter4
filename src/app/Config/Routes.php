<?php


use App\Controllers\Api\Auth\LoginController as ApiLoginController;
use App\Controllers\Api\Auth\RegisterController as ApiRegisterController;
use App\Controllers\Api\PatientController as ApiPatientController;
use App\Controllers\Web\HomeController;
use App\Controllers\Web\PatientController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Routes
service('auth')->routes($routes);

// Home Routes
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home.index']);

// Patient Routes
$routes->get('/patient', [PatientController::class, 'index'], ['as' => 'patient.index']);
$routes->get('/patient/create', [PatientController::class, 'create'], ['as' => 'patient.create']);
$routes->post('/patient', [PatientController::class, 'store'], ['as' => 'patient.store']);
$routes->get('/patient/(:num)/edit', [PatientController::class, 'edit'], ['as' => 'patient.edit']);
$routes->match(['put', 'patch'], '/patient/(:num)', [PatientController::class, 'update'], ['as' => 'patient.update']);
$routes->delete('/patient/(:num)', [PatientController::class, 'destroy'], ['as' => 'patient.destroy']);
$routes->patch('/patient/(:num)/active', [PatientController::class, 'active'], ['as' => 'patient.active']);

/**
 * Api Routes
 */

// Auth Routes
$routes->post('/api/login', [ApiLoginController::class, 'login']);
$routes->post('/api/register', [ApiRegisterController::class, 'register']);

$routes->group('api', ['filter' => 'tokens'], static function ($routes) {
    // Patient Routes
    $routes->get('patient', [ApiPatientController::class, 'index']);
    $routes->post('patient', [ApiPatientController::class, 'store']);
    $routes->get('patient/(:num)', [ApiPatientController::class, 'show']);
    $routes->match(['put', 'patch'], 'patient/(:num)', [ApiPatientController::class, 'update']);
    $routes->delete('patient/(:num)', [ApiPatientController::class, 'destroy']);
    $routes->patch('patient/(:num)/active', [ApiPatientController::class, 'active']);
});
