<?php
require_once '../src/utils/Response.php';

// Debugging (Uncomment if needed)
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

// CORS Headers (Crucial for JS fetch)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Master-Token");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// URL Structure
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = DIR_BACKEND_STR . '/';
$route = str_replace($base, '', $requestUri);
$parts = explode('/', $route);

$method = $_SERVER['REQUEST_METHOD'];

// *** FIX: METHOD OVERRIDE FOR FILE UPLOADS ***
// If we send POST with a field "_method=PATCH", treat it as PATCH.
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

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

// Authentication (Keep your existing logic)
$authController = new AuthController();
$sessionToken = trim(str_replace('Bearer', '', $headers['Authorization'] ?? null));
$sessionData = $authController->checkAuthGuard($sessionToken);

$id = $_GET['id'] ?? $data['id'] ?? null;

switch ($type) {
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
                // Now supports $_FILES because the real request was POST
                $controller->updateItem($data, $_FILES);
                break;
            case 'DELETE':
                $controller->deleteItem($id);
                break;
            default:
                Response::json(['error' => 'Invalid Method'], 405);
        }
        break;

    // ... (Keep other cases: user, category, orders, seating, auth exactly as they were) ...
    // I am omitting them here to save space, but DO NOT DELETE THEM in your file.

    // Quick re-insert of AUTH for safety since it's vital
    case 'auth':
        switch ($method) {
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $authController->login($data);
                break;
            case 'GET':
                if ($sessionData) {
                    Response::json(['role' => $sessionData['role'], 'name' => $sessionData['name']], 200);
                } else {
                    Response::json(['message' => 'Invalid or expired token.'], 401);
                }
                break;
        }
        break;

    default:
        // Fallback for known routes not fully pasted here
        if (in_array($type, ['user', 'category', 'orders', 'seating'])) {
            // You should keep your original switch cases for these!
            // This block is just a placeholder if you copy-paste blindly.
            Response::json(['error' => 'Route exists but code hidden in this snippet'], 500);
        } else {
            Response::json(['error' => 'Invalid URL.'], 404);
        }
        break;
}
