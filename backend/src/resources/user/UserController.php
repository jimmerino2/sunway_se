<?php
require_once "../src/config/db.php";
require_once 'UserModel.php';
// require_once __DIR__ . '/../../utils/Response.php';
require_once __DIR__ . '/../../utils/Response.php'; // This is CORRECT
require_once __DIR__ . '/../auth/AuthModel.php'; // Include AuthModel to verify old password

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    public function listUser($filters)
    {
        $users = $this->userModel->listUser($filters);
        if ($users) {
            Response::json($users);
        } else {
            Response::json(null);
        }
    }

    public function getUser($id)
    {
        $user = $this->userModel->getUser($id);
        if ($user) {
            Response::json($user);
        } else {
            Response::json(['error' => 'User not found.'], 404);
        }
    }

    public function createUser($data)
    {
        // Ensure all required fields are filled
        foreach ($this->userModel->columns as $column) {
            if ($column['name'] === 'id') {
                continue;
            }
            if ($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        // Email format
        if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $data['email'])) {
            Response::json(['error' => "Invalid email format."], 400);
            return;
        }

        // Check for unique user 
        $isEmailTaken = $this->userModel->checkUniqueEmail(0, $data['email']);
        if ($isEmailTaken) {
            Response::json(['error' => 'There is already a user with this email address.'], 400);
            return;
        }

        // Hashing for creation is handled in UserModel->saveUser, but we ensure it's here if saveUser changes
        // $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT); 

        $success = $this->userModel->saveUser($data);
        return $success
            ? Response::json(['message' => 'User successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this user.'], 400);
    }

    public function updateUser($data)
    {
        if (isset($data['id'])) {
            $userId = $data['id'];

            // 1. Password Modification Logic (HASHING AND OLD PASSWORD VERIFICATION)
            if (isset($data['password']) && isset($data['old_password'])) {
                // Fetch current user details to get the current stored hash
                $currentUser = $this->userModel->getUser($userId);

                if (!$currentUser || !password_verify($data['old_password'], $currentUser['password'])) {
                    // Password verification failed
                    Response::json(['error' => 'The provided current password is incorrect.'], 400);
                    return;
                }

                // HASH THE NEW PASSWORD before passing it to the model
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

                // Remove the old_password field before sending to model
                unset($data['old_password']);
            } elseif (isset($data['password']) || isset($data['old_password'])) {
                // If one but not both password fields were provided, this is an invalid state
                Response::json(['error' => 'Missing old or new password for security change.'], 400);
                return;
            }

            // 2. Email Uniqueness Check
            $isEmailTaken = $this->userModel->checkUniqueEmail($userId, $data['email']);
            if ($isEmailTaken) {
                Response::json(['error' => 'There is already a user with this email address.'], 400);
                return;
            }

            // 3. Perform Update
            $success = $this->userModel->updateUser($data);
            return $success
                ? Response::json(['message' => 'User successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this user.'], 400);
        } else {
            Response::json(['error' => 'User ID not set.'], 400);
        }
    }

    public function deleteUser($id)
    {
        if ($id != null) {
            $isUserExist = $this->userModel->getUser($id);

            if ($isUserExist) {
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
