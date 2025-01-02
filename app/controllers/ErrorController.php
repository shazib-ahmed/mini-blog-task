<?php

/**
 * Error Controller Class
 * 
 * Handles the display of various HTTP error pages in the application.
 * This controller manages different error states and renders appropriate
 * error views with correct HTTP status codes.
 */
class ErrorController
{
    /**
     * Displays 404 Not Found error page
     * 
     * Sets HTTP response code to 404 and renders the corresponding view.
     * @return void
     */
    public function show404()
    {
        http_response_code(404);
        require '../public/views/errors/404.php';
        exit;
    }

    /**
     * Displays 500 Internal Server Error page
     * 
     * Sets HTTP response code to 500 and renders the corresponding view.
     * @return void
     */
    public function show500()
    {
        http_response_code(500);
        require '../public/views/errors/500.php';
        exit;
    }

    /**
     * Displays 403 Forbidden error page
     * 
     * Sets HTTP response code to 403 and renders the corresponding view.
     * @return void
     */
    public function show403()
    {
        http_response_code(403);
        require '../public/views/errors/403.php';
        exit;
    }
}
