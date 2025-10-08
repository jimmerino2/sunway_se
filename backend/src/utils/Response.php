<?php

class Response {
    public static function json($data, $status = 200) {
        http_response_code($status);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}
