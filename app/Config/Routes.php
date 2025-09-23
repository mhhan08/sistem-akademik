<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::prosesLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/dashboard', 'DashboardController::index');

    $routes->group('admin', function ($routes) {
        $routes->resource('courses', ['controller' => 'AdminCoursesController']);
        $routes->resource('students', ['controller' => 'AdminStudentsController']);
    });

    $routes->group('mahasiswa', function ($routes) {
        $routes->get('courses', 'MahasiswaController::courses');
        $routes->get('myCourses', 'MahasiswaController::myCourses');
        $routes->post('process-enroll', 'MahasiswaController::processEnrollment');
    });
});