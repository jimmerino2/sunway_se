<?php
require_once "../src/config/db.php";
require_once "../src/config/site_config.php";
require_once '../src/resources/user/UserController.php';
require_once '../src/resources/auth/AuthController.php';
require_once '../src/utils/Response.php';

// Structure URL 
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND_STR . '/';
$route = str_replace($base, '', $requestUri);
$parts = explode('/', $route);
$method = $_SERVER['REQUEST_METHOD'];
$type = $parts[0];

// Get contents
$headers = getallheaders();
$data = json_decode(file_get_contents('php://input'), true);

// Authentication
$authController = new AuthController();
$sessionToken = trim(str_replace('Bearer', '', $headers['Authorization'] ?? null));

switch ($type) {
    case 'user':
        if(!$authController->checkAuthGuard($sessionToken)) {
            Response::json(['error' => 'Access denied.'], 401);
            break;
        } 
        $controller = new UserController();
        $id = $_GET['id'] ?? $data['id'] ?? null;
        switch ($method) {
            case 'GET':
                $id ? $controller->getUser($id) : $controller->listUser($_GET);
                break;
            case 'POST':
                $controller->createUser($data);
                break;
            case 'PATCH':
                $controller->updateUser($data);
                break;
            case 'DELETE':
                $controller->deleteUser($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'auth':
        switch ($method) {
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $authController->login($data);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
                break;
        }
        break;
    default:
        echo json_encode(['error' => 'Invalid URL.']);
        break;
}
