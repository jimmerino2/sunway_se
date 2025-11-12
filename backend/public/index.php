<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once "../src/config/db.php";
require_once "../src/config/site_config.php";
require_once '../src/resources/user/UserController.php';
require_once '../src/resources/auth/AuthController.php';
require_once '../src/resources/category/CategoryController.php';
require_once '../src/resources/seating/SeatingController.php';
require_once '../src/resources/item/ItemController.php';
require_once '../src/resources/orders/OrdersController.php';
require_once '../src/utils/Response.php';

// Structure URL 
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND_STR . '/';
$route = str_replace($base, '', $requestUri);
$parts = explode('/', $route);
$method = $_SERVER['REQUEST_METHOD'];

$type = $parts[0];
$specification = $parts[1] ?? null;

// Get contents
$headers = getallheaders();
$contentType = $headers['Content-Type'] ?? '';
if (str_contains($contentType, 'application/json')) {
    $data = json_decode(file_get_contents('php://input'), true);
} else {
    $data = $_POST;
}

// Authentication
$authController = new AuthController();
$sessionToken = trim(str_replace('Bearer', '', $headers['Authorization'] ?? null));
$sessionRole = $authController->checkAuthGuard($sessionToken); // A, K, C

// $_GET Handler
$id = $_GET['id'] ?? $data['id'] ?? null;

switch ($type) {
    case 'user':
        if ($sessionRole != 'A') {
            Response::json(['error' => 'Access denied.'], 401);
            break;
        }
        $controller = new UserController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getUser($id) : $controller->listUser($_GET);
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
    case 'category':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new CategoryController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getCategory($id) : $controller->listCategory($_GET);
                break;
            case 'POST':
                $controller->createCategory($data);
                break;
            case 'PATCH':
                $controller->updateCategory($data);
                break;
            case 'DELETE':
                $controller->deleteCategory($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'item':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new ItemController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getItem($id) : $controller->listItem($_GET);
                break;
            case 'POST':
                $controller->createItem($data, $_FILES);
                break;
            case 'PATCH':
                $controller->updateItem($data, $_FILES);
                break;
            case 'DELETE':
                $controller->deleteItem($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'orders':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new OrdersController();
        switch ($method) {
            case 'GET':
                switch ($specification) {
                    case null:
                        (!is_null($id)) ? $controller->getOrders($id) : $controller->listOrders($_GET);
                        break;
                    case 'rate_orders':
                        $controller->getRateOrders();
                        break;
                    case 'rate_income':
                        $controller->getRateIncome();
                        break;
                    default:
                        Response::json(['error' => 'Invalid URL.'], 405);
                        break;
                }
                break;
            case 'POST':
                $controller->createOrders($data);
                break;
            case 'PATCH':
                if (isset($data['action']) && $data['action'] === 'clear_table') {
                    $controller->clearOrders($data); // Call your new function
                } else {
                    $controller->updateOrders($data); // Call the normal update function
                }
                break;
            case 'DELETE':
                $controller->deleteOrders($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'seating':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new SeatingController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getSeating($id) : $controller->listSeating($_GET);
                break;
            case 'POST':
                $controller->createSeating($data);
                break;
            case 'PATCH':
                $controller->updateSeating($data);
                break;
            case 'DELETE':
                $controller->deleteSeating($id);
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
