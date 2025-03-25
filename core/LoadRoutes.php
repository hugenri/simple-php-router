<?php

namespace core;

use core\Router;

/**
 * LoadRoutes Class
 * 
 * Loads routes from a Routes.php file.
 */
class LoadRoutes {
    public static function load(): Router {
        require_once 'routes/Routes.php';
        return $router; // Return the router instance
    }
}