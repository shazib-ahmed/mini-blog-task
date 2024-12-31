<?php
require_once '../app/config/database.php';
require_once '../app/controllers/PostController.php';

// require_once(__DIR__ . '/../app/config/database.php');
// require_once(__DIR__ . '/../app/controllers/PostController.php');

$config = include('../app/config/database.php');

try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']}",
        $config['username'],
        $config['password']
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$controller = new PostController($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if ($request[0] === 'posts') {
    switch ($method) {
        case 'GET':
            if (isset($request[1])) {
                $controller->show($request[1]);
            } else {
                $controller->index();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $controller->store($data);
            break;
        case 'PUT':
            parse_str(file_get_contents('php://input'), $data);
            $controller->update($request[1], $data);
            break;
        case 'DELETE':
            $controller->destroy($request[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
}
