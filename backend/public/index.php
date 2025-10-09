<?php
require_once "../src/config/db.php";
require_once "../src/config/site_config.php";
require_once '../src/controllers/UserController.php';
require_once '../src/utils/Response.php';

$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND;
$route = str_replace($base, '', $requestUri);
$parts = explode('/', $route);
$method = $_SERVER['REQUEST_METHOD'];

$type = $parts[0];

switch ($type) {
    case 'user':
        $controller = new UserController();
        switch ($method) {
            case 'GET':
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $controller->getUser($id);
                } else {
                    $controller->getAllUsers();
                }
                break;

            case 'POST':
                $controller->createUser();
                break;

            case 'PUT':
                $controller->updateUser($id);
                break;

            case 'DELETE':
                $controller->deleteUser($id);
                break;

            default:
                Response::json(['error' => 'Method not allowed'], 405);
                break;
        }
        break;
    default:
        echo json_encode(['error' => 'Invalid URL.']);
        break;
}
