<?php
require_once "../src/config/db.php";
require_once 'AuthModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new authModel();
    }

    public function login($data)
    {
        if (empty($data['email']) || empty($data['password'])) {
            // Just send the error message. Response::json will handle the structure.
            return Response::json(['message' => 'Invalid login details.'], 400);
        }

        $token = $this->authModel->login($data);

        if ($token) {
            // Get the user details (this is from AuthModel, which is correct)
            $userDetails = $this->authModel->getUserDetailsByEmail($data['email']);
            return Response::json([
                'message' => 'Login success.',
                'token'   => $token,
                'name'    => $userDetails['name'] ?? 'User',
                'role'    => $userDetails['role'] ?? 'user'
            ], 200);
        }

        // Just send the error message for failure
        return Response::json(['message' => 'Invalid login details.'], 400);
    }

    public function checkAuthGuard($token)
    {
        return $this->authModel->checkAuthGuard($token);
    }
}
