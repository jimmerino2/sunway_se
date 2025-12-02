<?php
require_once '../src/config/db.php';

class UserModel {
    private PDO $db;
    private string $tableName = 'users'; 
    public array $columns = [
        ['name' => 'id',       'required' => true],
        ['name' => 'name',     'required' => true],
        ['name' => 'email',    'required' => true],
        ['name' => 'role',     'required' => true],
        ['name' => 'password', 'required' => true],
    ];


    public function __construct() {
        $this->db = getPDO();
    }

    public function listUser($filters = []) {
        $sql = "SELECT * FROM {$this->tableName} WHERE 1=1";

        // Set conditions
        $condition = "";
        $params = [];
        if(!empty($filters)){
            // Remove false parameters
            $validColumns = array_column($this->columns, 'name');
            foreach ($filters as $key => $value) {
                if (!in_array($key, $validColumns)) {
                    unset($filters[$key]);
                }
            }

            foreach ($filters as $key => $value) {
                $sql .= " AND $key = :$key";
                $params[$key] = $value;
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getUser($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function checkUniqueEmail($id, $email) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id != ? AND email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function saveUser($data) {
        // Remove false parameters
        $validColumns = array_column($this->columns, 'name');
        foreach ($data as $key => $value) {
            if (!in_array($key, $validColumns) || $key === 'id') {
                unset($data[$key]);
            }
        }

        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ':' . $f, $fields);

        $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $stmt->execute($data);   
    }

    public function updateUser(array $data): bool {
        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($data)));

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function deleteUser(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ? AND id != 1";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
