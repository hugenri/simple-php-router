<?php

namespace core;

use core\View;
use core\Redirect;

/**
 * BaseController Abstract Class
 * 
 * Provides foundational controller functionality and dependency injection
 * for view rendering and HTTP redirections. All application controllers
 * should extend this base class.
 */
abstract class BaseController
{
    /**
     * @var View $view View rendering service instance
     */
    protected $view;
    
    /**
     * @var Redirect $redirect HTTP redirection service instance
     */
    protected $redirect;

    /**
     * BaseController Constructor
     * 
     * Initializes controller dependencies including:
     * - View rendering system
     * - HTTP redirection service
     */
    public function __construct()
    {
        // Inject dependencies
        $this->view = new View();
        $this->redirect = new Redirect();
    }

    /**
     * Magic Method __call
     * 
     * Provides dynamic method delegation to:
     * - View methods (render)
     * - Redirect methods (to, route, etc.)
     * 
     * @param string $method Method name being called
     * @param array $args Arguments passed to method
     * @return mixed
     * @throws \BadMethodCallException When method doesn't exist in services
     * 
     * @example $this->render('view') // Delegates to $this->view->render()
     * @example $this->route('/path') // Delegates to $this->redirect->route()
     */
    public function __call($method, $args)
    {
        // Delegate to View service if method exists
        if (method_exists($this->view, $method)) {
            return call_user_func_array([$this->view, $method], $args);
        }

        // Delegate to Redirect service if method exists
        if (method_exists($this->redirect, $method)) {
            return call_user_func_array([$this->redirect, $method], $args);
        }

        throw new \BadMethodCallException(
            "Method {$method} not found in View or Redirect services"
        );
    }
}