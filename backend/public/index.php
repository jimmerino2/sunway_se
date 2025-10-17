<?php
require_once "../src/config/db.php";
require_once "../src/config/site_config.php";
require_once '../src/resources/user/UserController.php';
require_once '../src/utils/Response.php';

$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND_STR . '/';
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
                if($id != null){
                    $controller->getUser($id);
                } else {
                    $filters = $_GET;
                    $controller->listUser($filters);
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->createUser($data);
                break;
            case 'PATCH':
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->updateUser($data);
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->deleteUser($data['id'] ?? null);
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
