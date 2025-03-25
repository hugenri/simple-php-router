<?php

use core\Router;
use controllers\HomeController;
use controllers\UserController;
use middlewares\AuthMiddleware;
use core\LoadRoutes;
use core\EnvLoader;

// Register the autoloader
require_once 'core/Autoloader.php';
Autoloader::register();

// Load environment variables
EnvLoader::load();

// Load routes and get the router
$router = LoadRoutes::load();
// Dispatch the route
$router->dispatch();