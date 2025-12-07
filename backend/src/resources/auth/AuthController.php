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
            return Response::json(['message' => 'Invalid login details.'], 400);
        }

        // CHECK FOR DEACTIVATED ACCOUNT FIRST
        $userDetails = $this->authModel->getUserDetailsByEmail($data['email']);

        // Note: You may need to update getUserDetailsByEmail in AuthModel 
        // to select the 'active' column as well for this specific logic
        if ($userDetails && isset($userDetails['active']) && $userDetails['active'] == 0) {
            return Response::json(['message' => 'Your account has been deactivated.'], 403);
        }

        $token = $this->authModel->login($data);

        if ($token) {
            return Response::json([
                'message' => 'Login success.',
                'token'   => $token,
                'name'    => $userDetails['name'] ?? 'User',
                'role'    => $userDetails['role'] ?? 'user'
            ], 200);
        }

        return Response::json(['message' => 'Invalid login details.'], 400);
    }

    public function checkAuthGuard($token)
    {
        return $this->authModel->checkAuthGuard($token);
    }
}
