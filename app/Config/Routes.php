<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');#home

$routes->get('/hello', 'Home::hello');#hello world with ci4

$routes->get('mahasiswa/table','Table::HTML');#table html manual

$routes->get('mahasiswa/table/database', 'Table::table_mhs');#table html with looping from database mahasiswa

$routes->get('mahasiswa/table/list','Table::table_link_mhs');#table biodata from database mahasiswa to detail mahasiswa with link

$routes->get('mahasiswa/table/(:segment)',"Table::detail_mhs/$1");#table detail mahasiswa from link 

#CRUD

#read
$routes->get('mahasiswa', 'CRUD::read_mhs');#read all data from database with loop

#create
$routes->get('mahasiswa/add',"CRUD::view_create_mhs");#create new biodata mahasiswa
$routes->post('mahasiswa/add/simpan','CRUD::create_mhs');#save new mahasiswa to database

#update
$routes->get('mahasiswa/edit/(:segment)', 'CRUD::edit/$1');#update biodata mahasiswa with url edit/nim-target
$routes->post('mahasiswa/update/(:segment)', 'CRUD::update/$1');#update biodata mahasiswa and save to database

#delete
$routes->get('mahasiswa/delete/(:segment)', 'CRUD::delete_mhs/$1');#delete biodata mahasiswa from link provided with url



