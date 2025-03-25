<?php

namespace middlewares;

/**
 * Authentication Middleware
 * 
 * Verifies user authentication status by checking session.
 * Terminates request with 401 Unauthorized if no user is authenticated.
 */
class AuthMiddleware 
{
    /**
     * Initialize middleware and start session
     */
    public function __construct() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Execute authentication check
     * 
     * @return void
     * @throws \Exception If user is not authenticated
     */
    public function handle() 
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: text/plain');
            echo "Unauthorized access. Please login first.";
            exit;
        }
    }
}