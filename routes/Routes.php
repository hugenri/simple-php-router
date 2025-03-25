<?php

use core\Router;
use controllers\HomeController;
use controllers\UserController;
use middlewares\AuthMiddleware;

/**
 * Application Routes Configuration
 * 
 * Defines all HTTP routes and their corresponding controllers and middlewares.
 */

// Initialize router instance
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/login', 'HomeController@login');
$router->get('/user', 'UserController@index')->middleware('AuthMiddleware');
$router->get('/user/{id}', 'UserController@show')->middleware('AuthMiddleware');
$router->post('/user', 'UserController@create')->middleware('AuthMiddleware');
$router->put('/user/{id}', 'UserController@update')->middleware('AuthMiddleware');
$router->delete('/user/{id}', 'UserController@delete')->middleware('AuthMiddleware');
