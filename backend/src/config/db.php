<?php
require_once __DIR__ . '/site_config.php';

function getPDO(): PDO {
    static $pdo = null; 

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            die(json_encode(["error" => "Database connection failed"]));
        }
    }

    return $pdo;
}
?>