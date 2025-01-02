<?php
require_once '../app/config/database.php';
require_once '../app/controllers/PostController.php';
require_once '../app/controllers/ViewController.php';
require_once '../app/controllers/ErrorController.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$config = include('../app/config/database.php');

try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']}",
        $config['username'],
        $config['password']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$postController = new PostController($db);
$viewController = new ViewController();
$errorController = new ErrorController();

// Get the request URI
$request_uri = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', trim($request_uri, '/'));

// Block direct access to views directory
if ($url_parts[0] === 'views') {
    $errorController->show403();
}

// Set error handlers
set_error_handler(function($errno, $errstr, $errfile, $errline) use ($errorController) {
    $errorController->show500();
});

set_exception_handler(function($exception) use ($errorController) {
    $errorController->show500();
});

// Route the request
try {
    if (strpos($request_uri, '/api/') === 0) {
        // Handle API routes
        if ($url_parts[1] === 'posts') {
            $method = $_SERVER['REQUEST_METHOD'];
            
            switch ($method) {
                case 'GET':
                    if (isset($url_parts[2])) {
                        $postController->show($url_parts[2]);
                    } else {
                        $postController->index();
                    }
                    break;

                case 'POST':
                    $postController->store();
                    break;

                case 'PUT':
                    if (isset($url_parts[2])) {
                        $postController->update($url_parts[2]);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Post ID is required']);
                    }
                    break;

                case 'DELETE':
                    if (isset($url_parts[2])) {
                        $postController->delete($url_parts[2]);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Post ID is required']);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Method not allowed']);
                    break;
            }
        } else {
            $errorController->show404();
        }
    } else {
        // Handle view routes
        switch ($url_parts[0]) {
            case '':
                $viewController->index();
                break;
                
            case 'create':
                $viewController->create();
                break;
                
            case 'edit':
                if (isset($url_parts[1])) {
                    $viewController->edit($url_parts[1]);
                } else {
                    $errorController->show404();
                }
                break;

            case 'view':
                if (isset($url_parts[1])) {
                    $viewController->view($url_parts[1]);
                } else {
                    $errorController->show404();
                }
                break;
                
            default:
                $errorController->show404();
        }
    }
} catch (Exception $e) {
    $errorController->show500();
}
