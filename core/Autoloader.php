<?php

/**
 * Autoloader Class
 * 
 * Provides automatic class loading functionality for the application.
 * Implements PSR-4 compatible autoloading using namespaces to file path conversion.
 */
class Autoloader
{
    /**
     * Registers the autoloader function with PHP's SPL autoloader stack.
     * 
     * This static method sets up a function that will automatically load class files
     * when they are first used, based on their namespace and class name.
     * 
     * Usage:
     * Autoloader::register();
     * 
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Convert namespace separators to directory separators
            $file = str_replace('\\', '/', $class) . '.php';

            // Check if the file exists before requiring it
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}