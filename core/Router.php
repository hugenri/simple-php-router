<?php

namespace core;

/**
 * Router Class
 * 
 * Manages routing and dispatching requests to controllers.
 */
class Router {
    private $routes = [];
    private $middlewareStack = [];

    /**
     * Adds a GET route
     * @param string $uri Route URI
     * @param string $action Controller action
     * @return $this
     */
    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
        return $this;
    }

    /**
     * Adds a POST route
     * @param string $uri Route URI
     * @param string $action Controller action
     * @return $this
     */
    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
        return $this;
    }

    /**
     * Adds a PUT route
     * @param string $uri Route URI
     * @param string $action Controller action
     * @return $this
     */
    public function put($uri, $action) {
        $this->addRoute('PUT', $uri, $action);
        return $this;
    }

    /**
     * Adds a DELETE route
     * @param string $uri Route URI
     * @param string $action Controller action
     * @return $this
     */
    public function delete($uri, $action) {
        $this->addRoute('DELETE', $uri, $action);
        return $this;
    }

    /**
     * Adds a route
     * @param string $method HTTP method
     * @param string $uri Route URI
     * @param string $action Controller action
     * @return $this
     */
    private function addRoute($method, $uri, $action) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => []
        ];
    }

    /**
     * Adds middleware to the last route
     * @param string $middleware Middleware class name
     * @return $this
     */
    public function middleware($middleware) {
        $lastRouteIndex = count($this->routes) - 1;
        $this->routes[$lastRouteIndex]['middleware'][] = $middleware;
        return $this;
    }

    /**
     * Dispatches the request to the appropriate controller
     */
    public function dispatch() {
        $requestUri = $this->getRelativeUri($_SERVER['REQUEST_URI']);  // Call the function to get the relative URI
        $requestMethod = $_SERVER['REQUEST_METHOD'];
  
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['uri']);
            $pattern = "@^" . $pattern . "$@";

            if (preg_match($pattern, $requestUri, $matches) && $route['method'] === $requestMethod) {
                // Extract dynamic parameters
                array_shift($matches);
                $params = $matches;
                
                // Execute middleware
                $this->executeMiddleware($route['middleware']);
                // Call the controller and action
                $this->callAction($route['action'], $params);
                return;
            }
        }

        // If no route is found, show a 404 error
        http_response_code(404);
        echo "Page not found";
    }

    /**
     * Executes middleware
     * @param array $middlewares Middleware classes
     */
    private function executeMiddleware($middlewares) {
         
        foreach ($middlewares as $middleware) {
            $middlewareClass = 'middlewares\\' . $middleware;
            $middlewareClass = new $middlewareClass();
            $middlewareClass->handle();
        }
    }

    /**
     * Calls the controller and action
     * @param string $action Controller action
     * @param array $params Parameters
     */
    private function callAction($action, $params = []) {
        list($controllerClass, $method) = explode('@', $action);
        $controllerClass = 'controllers\\' . $controllerClass;
        $controller = new $controllerClass();

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(500);
            echo "Error: El método {$method} no existe en el controlador {$controllerClass}";
        }
    }

    /**
     * Gets the relative URI (without the BASE_URL prefix)
     * @return string Relative URI
     */
    private function getRelativeUri() {
        $baseUri = parse_url($_ENV['BASE_URL'], PHP_URL_PATH); // Get the BASE_URL prefix
        // Get the requested URI
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Check if the current URI starts with BASE_URL
        if (strpos($requestUri, $baseUri) === 0) {
            // Remove the BASE_URL prefix from the URI
            return "/".substr($requestUri, strlen($baseUri));
        }

        // If the URI does not start with BASE_URL, return the URI as is
        return $requestUri;
    }
}



