<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/Response.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getAllUsers() {
        $users = $this->userModel->getAll();
        Response::json($users);
    }

    public function getUser($id) {
        $user = $this->userModel->find($id);
        if ($user) {
            Response::json($user);
        } else {
            Response::json(['error' => 'User not found'], 404);
        }
    }

    public function createUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['name']) || empty($data['email'])) {
            Response::json(['error' => 'Name and email are required'], 400);
            return;
        }

        $user = $this->userModel->create($data);
        Response::json(['message' => 'User created', 'data' => $user], 201);
    }

    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $updated = $this->userModel->update($id, $data);
        Response::json(['updated' => $updated]);
    }

    public function deleteUser($id) {
        $deleted = $this->userModel->delete($id);
        Response::json(['deleted' => $deleted]);
    }
}
