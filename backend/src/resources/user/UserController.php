<?php
require_once "../src/config/db.php";
require_once 'UserModel.php';
require_once DIR_BACKEND . '\utils\Response.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new userModel();
    }

    public function listUser($filters) {
        $users = $this->userModel->listUser($filters);
        if ($users) {
            Response::json($users);
        } else {
            Response::json(null);
        }
    }

    public function getUser($id) {
        $user = $this->userModel->getUser($id);
        if ($user) {
            Response::json($user);
        } else {
            Response::json(['error' => 'User not found.'], 404);
        }
    }

    public function createUser($data) {
        // Ensure all required fields are filled
        foreach ($this->userModel->columns as $column) {
            if($column['name'] === 'id') {continue;}
            if($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);   
                return;
            }
        }

        // Email format
        if(!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $data['email'])){
            Response::json(['error' => "Invalid email format."], 400);   
            return;
        }
        
        // Check for unique user 
        $isEmailTaken = $this->userModel->checkUniqueEmail(0, $data['email']);
        if($isEmailTaken){
            Response::json(['error' => 'There is already a user with this email address.'], 400);   
            return;
        }

        $success = $this->userModel->saveUser($data);
        return $success
            ? Response::json(['message' => 'User successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this user.'], 400);
    }

    public function updateUser($data) {
        if(isset($data['id'])){
             // Check for unique user 
            $isEmailTaken = $this->userModel->checkUniqueEmail($data['id'], $data['email']);
            if($isEmailTaken){
                Response::json(['error' => 'There is already a user with this email address.'], 400);   
                return;
            }

            $success = $this->userModel->updateUser($data);
            return $success
                ? Response::json(['message' => 'User successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this user.'], 400);
        } else {
            Response::json(['error' => 'User ID not set.'], 400);
        }
    }

    public function deleteUser($id) {
        if($id != null){
            $isUserExist = $this->userModel->getUser($id);

            if($isUserExist){
                $success = $this->userModel->deleteUser($id);
                return $success
                    ? Response::json(['message' => 'User successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this user.'], 400);
            } else {
                Response::json(['error' => 'User does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'User ID not set.'], 400);
        }
    }
}
