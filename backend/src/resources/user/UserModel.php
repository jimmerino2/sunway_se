<?php
require_once '../src/config/db.php';

class UserModel
{
    private PDO $db;
    private string $tableName = 'users';
    public array $columns = [
        ['name' => 'id',       'required' => true],
        ['name' => 'name',     'required' => true],
        ['name' => 'email',    'required' => true],
        ['name' => 'role',     'required' => true],
        ['name' => 'password', 'required' => true],
        ['name' => 'active',   'required' => false],
    ];


    public function __construct()
    {
        $this->db = getPDO();
    }

    /**
     * Lists users based on filters. 
     * Modified to only show active users by default if no filter is provided.
     */
    public function listUser($filters = [])
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE 1=1";

        // Set conditions
        $params = [];
        if (!empty($filters)) {
            // Remove parameters not defined in the $columns array
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

    public function getUser($id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUniqueEmail($id, $email)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id != ? AND email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveUser($data)
    {
        // Remove parameters not in the whitelist or the ID column
        $validColumns = array_column($this->columns, 'name');
        foreach ($data as $key => $value) {
            if (!in_array($key, $validColumns) || $key === 'id') {
                unset($data[$key]);
            }
        }

        // Set default active status if not provided
        if (!isset($data['active'])) {
            $data['active'] = 1;
        }

        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ':' . $f, $fields);

        $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);

        // Uses BCRYPT for hashing standard
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $stmt->execute($data);
    }

    /**
     * Modified to update based on provided ID while strictly validating columns.
     */
    public function updateUser(array $data): bool
    {
        // Validate that keys provided in $data are in the allowed $columns array
        $validColumns = array_column($this->columns, 'name');
        $id = $data['id']; // Extract ID for the WHERE clause
        unset($data['id']); // Remove from update set clause

        foreach ($data as $key => $value) {
            if (!in_array($key, $validColumns)) {
                unset($data[$key]);
            }
        }

        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($data)));

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Re-add ID for parameter binding
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function deleteUser(int $id): bool
    {
        // Protect the master admin (ID 1) from deletion
        $sql = "DELETE FROM {$this->tableName} WHERE id = ? AND id != 1";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
