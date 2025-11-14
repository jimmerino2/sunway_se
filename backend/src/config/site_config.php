<?php

// The path is now corrected to jump three levels up to the project root.
require_once __DIR__ . '/../../../vendor/autoload.php';

try {
    // This path is correct for locating the .env file in the project root.
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
    $dotenv->safeLoad();
} catch (Exception $e) {
}

define("DIR_CONFIG", __DIR__);

// Removed failsafe options - relies entirely on .env variables being set.
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);

$dbAuthString = $_ENV['DB_AUTH'];
define("DB_AUTH", filter_var($dbAuthString, FILTER_VALIDATE_BOOLEAN));

define("DIR_BACKEND", __DIR__ . "/../");
define("DIR_BACKEND_STR", "software_engineering/backend");

date_default_timezone_set('Asia/Kuala_Lumpur');
