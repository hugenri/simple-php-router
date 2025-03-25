<?php

namespace core;

/**
 * HTTP Redirect Handler
 * 
 * Provides methods for various types of HTTP redirects with proper status codes.
 * Handles both absolute and relative URLs with BASE_URL support.
 */
class Redirect
{
    /**
     * Redirect to a URL (absolute or relative)
     * @param string $url Target URL
     * @param int $statusCode HTTP status code (default: 302)
     */
    public function to($url, $statusCode = 302)
    {
        if (strpos($url, '/') === 0 && defined('BASE_URL')) {
            $url = BASE_URL . $url;
        }
        header('Location: ' . $url, true, $statusCode);
        exit();
    }

    /**
     * Redirect to a route relative to BASE_URL
     * @param string $route Relative path (e.g. '/login')
     * @param int $statusCode HTTP status code
     * @throws \RuntimeException If BASE_URL is not defined
     */
    public function route($route, $statusCode = 302)
    {
        if (!isset($_ENV['BASE_URL'])) {
            throw new \RuntimeException('BASE_URL is not defined in environment');
        }
        $this->to($_ENV['BASE_URL'] . $route, $statusCode);
    }

    /**
     * Permanent redirect (301 Moved Permanently)
     * @param string $url Target URL
     */
    public function permanent($url)
    {
        $this->to($url, 301);
    }

    /**
     * POST-Redirect-GET pattern (303 See Other)
     * @param string $url Target URL
     */
    public function seeOther($url)
    {
        $this->to($url, 303);
    }

    /**
     * Redirect back to previous URL
     * @param string $fallback Fallback URL if no referrer
     * @param int $statusCode HTTP status code
     */
    public function back($fallback = '/', $statusCode = 302)
    {
        $url = $_SERVER['HTTP_REFERER'] ?? $fallback;
        $this->to($url, $statusCode);
    }
}