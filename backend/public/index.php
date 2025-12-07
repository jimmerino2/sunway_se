<?php
require_once '../src/utils/Response.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// These paths go up one level from 'public' to 'backend' and then into 'src'
require_once "../src/config/db.php";
require_once "../src/config/site_config.php";
require_once '../src/resources/user/UserController.php';
require_once '../src/resources/auth/AuthController.php';
require_once '../src/resources/category/CategoryController.php';
require_once '../src/resources/seating/SeatingController.php';
require_once '../src/resources/item/ItemController.php';
require_once '../src/resources/orders/OrdersController.php';

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

// --- FIX: Check for _method override for PATCH/PUT/DELETE tunneling ---
$methodOverride = $data['_method'] ?? null;
if ($methodOverride && in_array(strtoupper($methodOverride), ['PUT', 'PATCH', 'DELETE'])) {
    $method = strtoupper($methodOverride);
    // Remove it from data so it doesn't get passed to the controller
    unset($data['_method']);
}

$authController = new AuthController();
$sessionToken = trim(str_replace('Bearer', '', $headers['Authorization'] ?? null));
$sessionData = $authController->checkAuthGuard($sessionToken);


// $_GET Handler
$id = $_GET['id'] ?? $data['id'] ?? null;

switch ($type) {
    case 'user':

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

    // --- REGULAR USER TOKEN ROUTES ---
    case 'orders':
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
                    $controller->clearOrders($data);
                } else {
                    $controller->updateOrders($data);
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

            case 'GET':
                if ($sessionData) {
                    Response::json([
                        'role' => $sessionData['role'],
                        'name' => $sessionData['name']
                    ], 200);
                } else {
                    Response::json(['message' => 'Invalid or expired token.'], 401);
                }
                break;
            default:
                Response::json(['error' => 'Invalid URL.'], 405);
                break;
        }
        break;
    default:
        Response::json(['error' => 'Invalid URL.'], 404);
        break;
}
