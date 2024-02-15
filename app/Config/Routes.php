<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('register', 'AuthController::register');
$routes->post('login', 'AuthController::login');

$routes->resource('users', ['controller' => 'UsersController']);

// Equivalent to the following:
// $routes->get('users/new',                'UsersController::new');
// $routes->post('users',                   'UsersController::create');
// $routes->get('users',                    'UsersController::index');
// $routes->get('users/(:segment)',         'UsersController::show/$1');
// $routes->get('users/(:segment)/edit',    'UsersController::edit/$1');
// $routes->put('users/(:segment)',         'UsersController::update/$1');
// $routes->patch('users/(:segment)',       'UsersController::update/$1');
// $routes->delete('users/(:segment)',      'UsersController::delete/$1');