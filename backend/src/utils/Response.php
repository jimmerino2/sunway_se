<?php

class Response {
    public static function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');

        echo json_encode([
            'success' => $status >= 200 && $status < 300,
            'message' => $data['message'] ?? ($data['error'] ?? ''),
            'data' => $data
        ], JSON_PRETTY_PRINT);

        exit;
    }
}
