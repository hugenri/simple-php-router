<?php

namespace core;

/**
 * View Class
 * 
 * Handles rendering views and passing variables.
 */
class View {
    /**
     * Renders a view and passes variables
     * 
     * @param string $view Name of the view file (without extension)
     * @param array $data Variables para pasar a la vista
     */
    public  function render($view, $data = []) {
        // Extract variables from the $data array to individual variables
        extract($data);

        // Define the base path for views
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        // Check if the view file exists
        if (!file_exists($viewPath)) {
            throw new \Exception("La vista '{$view}' no se encontró en: " . $viewPath);
        }

        // Include the view
        require_once $viewPath;
    }

    
}