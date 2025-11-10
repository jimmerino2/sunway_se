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
            return Response::json(['error' => 'Invalid login details.'], 400);
        }

        $token = $this->authModel->login($data);
        if ($token) {
            $name = $this->authModel->getNameByEmail($data['email']);
            return Response::json(['message' => 'Login success.', 'token' => $token, 'name' => $name], 200);
        }

        return Response::json(['error' => 'Invalid login details.'], 400);
    }

    public function checkAuthGuard($token)
    {
        return $this->authModel->checkAuthGuard($token);
    }
}
