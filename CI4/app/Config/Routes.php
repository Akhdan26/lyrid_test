<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth
$routes->get('login', 'Auth::login');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('register', 'Auth::register');
$routes->post('auth/processRegister', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');

// Protected routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');

    // Users CRUD
    $routes->get('users', 'User::index');
    $routes->get('users/create', 'User::create');
    $routes->post('users/store', 'User::store');
    $routes->get('users/edit/(:num)', 'User::edit/$1');
    $routes->post('users/update/(:num)', 'User::update/$1');
    $routes->get('users/delete/(:num)', 'User::delete/$1');

    // Employees CRUD
    $routes->get('employees', 'Employee::index');
    $routes->get('employees/create', 'Employee::create');
    $routes->post('employees/store', 'Employee::store');
    $routes->get('employees/edit/(:num)', 'Employee::edit/$1');
    $routes->post('employees/update/(:num)', 'Employee::update/$1');
    $routes->get('employees/delete/(:num)', 'Employee::delete/$1');
});