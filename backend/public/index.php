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
require_once '../src/resources/order/OrderController.php';
require_once '../src/resources/order_details/OrderDetailsController.php';
require_once '../src/utils/Response.php';

// Structure URL 
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND_STR . '/';
$route = str_replace($base, '', $requestUri);
$parts = explode('/', $route);
$method = $_SERVER['REQUEST_METHOD'];
$type = $parts[0];

// var_dump($parts);
// exit;

// Get contents
$headers = getallheaders();
$data = json_decode(file_get_contents('php://input'), true);

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
                $controller->createItem($data);
                break;
            case 'PATCH':
                $controller->updateItem($data);
                break;
            case 'DELETE':
                $controller->deleteItem($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'order':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new OrderController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getOrder($id) : $controller->listOrder($_GET);
                break;
            case 'POST':
                $controller->createOrder($data);
                break;
            case 'PATCH':
                $controller->updateOrder($data);
                break;
            case 'DELETE':
                $controller->deleteOrder($id);
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
        }
        break;
    case 'order_details':
        //if($sessionRole != 'A') {
        //    Response::json(['error' => 'Access denied.'], 401);
        //    break;
        //} 
        $controller = new OrderDetailsController();
        switch ($method) {
            case 'GET':
                (!is_null($id)) ? $controller->getOrderDetails($id) : $controller->listOrderDetails($_GET);
                break;
            case 'POST':
                $controller->createOrderDetails($data);
                break;
            case 'PATCH':
                $controller->updateOrderDetails($data);
                break;
            case 'DELETE':
                $controller->deleteOrderDetails($id);
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
