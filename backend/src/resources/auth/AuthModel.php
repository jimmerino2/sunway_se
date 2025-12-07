<?php
require_once '../src/config/db.php';

class AuthModel
{
    private PDO $db;
    private string $tableName = 'session';

    public function __construct()
    {
        $this->db = getPDO();
    }

    public function checkAuthGuard($token, $authenticate = DB_AUTH)
    {
        if (!$authenticate) return 'Authenticated';
        if (empty($token)) return false;
        $tokenHashed = hash('sha256', $token);

        $sql = "SELECT session.user_id, users.role, users.name 
                FROM session 
                JOIN users ON session.user_id = users.id  
                WHERE token = ? AND expire_at > NOW()";


        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tokenHashed]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?? false;
    }

    public function getUserDetailsByEmail($email)
    {
        $sql = "SELECT name, role, active FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function login($data)
    {
        $sql = "SELECT id, email, password, active FROM users WHERE email = ? AND active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['email']]);
        $loginDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        // If no active user is found, the controller will proceed to return an error
        if ($loginDetails && password_verify($data['password'], $loginDetails['password'])) {
            $user_id = $loginDetails['id'];

            // Clear old session(s)
            $sql = "DELETE FROM {$this->tableName} WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);

            $token = bin2hex(random_bytes(32));
            $tokenHashed = hash('sha256', $token);
            $expire = date('Y-m-d H:i:s', strtotime('+3 hours'));

            // Create new session
            $sql = "INSERT INTO {$this->tableName} (user_id, token, expire_at) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $tokenHashed, $expire]);

            return $token;
        }
        return false;
    }
}
