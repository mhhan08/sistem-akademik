<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route: arahkan ke dashboard jika sudah login
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);

// ===== ROUTES UNTUK AUTH =====
$routes->get('/login', 'AuthController::login');          // form login
$routes->post('/login', 'AuthController::prosesLogin');   // proses login
$routes->get('/logout', 'AuthController::logout');        // logout

// Semua route di dalam group ini dilindungi oleh filter auth (harus login)
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // dashbooard untuk admin dan user
    $routes->get('/dashboard', 'DashboardController::index');

    //routes untuk admin
    $routes->group('admin', function ($routes) {
        //routes untuk control courses
        $routes->resource('courses', ['controller' => 'AdminCoursesController']);
        //routes untuk control students
        $routes->resource('students', ['controller' => 'AdminStudentsController']);
    });

    //routes untuk mahasiswa
    $routes->group('mahasiswa', function ($routes) {
        $routes->get('courses', 'MahasiswaController::courses');       // daftar mata kuliah yang bisa diambil
        $routes->get('myCourses', 'MahasiswaController::myCourses');   // daftar mata kuliah yang sudah diambil
        $routes->get('enroll/(:num)', 'MahasiswaController::enroll/$1'); // ambil/enroll mata kuliah tertentu
    });
});
