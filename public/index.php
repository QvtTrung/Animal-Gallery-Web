<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../bootstrap.php';

define('APPNAME', 'Animal Gallery');

session_start();

$router = new \Bramus\Router\Router();

// Auth routes
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');
$router->get('/register', '\App\Controllers\Auth\RegisterController@create');
$router->post('/register', '\\App\Controllers\Auth\RegisterController@store');
$router->get('/login', '\App\Controllers\Auth\LoginController@create');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');

$router->set404('\App\Controllers\Controller@sendNotFound');

//Home routes
$router->get('/', '\App\Controllers\HomeController@index');
$router->get('/home', '\App\Controllers\HomeController@index');

//Collection routes
$router->get('/mycollections', '\App\Controllers\CollectionsController@index');


//Create Collection
$router->get('/collections/create', '\App\Controllers\CollectionsController@create');
$router->post('/collections', '\App\Controllers\CollectionsController@store');

//Edit Collection
$router->get('/collections/edit/(\d+)',
'\App\Controllers\CollectionsController@edit');
$router->post('/collections/(\d+)',
'\App\Controllers\CollectionsController@update');

//Delete Collection
$router->post('/collections/delete/(\d+)',
    '\App\Controllers\CollectionsController@destroy'); 

//Images routes
$router->get('/mycollections/(\d+)',
    '\App\Controllers\DetailController@index');

//Add Images to collection
$router->post('/mycollections/addToCollection/(\d+)', '\App\Controllers\DetailController@addToCollection');

//Remove Images from collection
$router->post('/mycollections/removeFromCollection/(\d+)/(\d+)', '\App\Controllers\DetailController@removeFromCollection');

$router->run();
