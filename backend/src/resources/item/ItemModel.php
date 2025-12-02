<?php
require_once '../src/config/db.php';

class ItemModel
{
    private PDO $db;
    private string $tableName = 'item';

    public array $columns = [
        ['name' => 'id', 'required' => true],
        ['name' => 'name', 'required' => true],
        ['name' => 'desc', 'required' => false],
        ['name' => 'price', 'required' => true],
        ['name' => 'category_id', 'required' => true],
    ];

    public function __construct()
    {
        $this->db = getPDO();
    }

    public function listItem($filters = [])
    {
        $sql = "SELECT i.*, c.name AS 'category_name' FROM {$this->tableName} i LEFT JOIN category c ON i.category_id = c.id WHERE 1=1";
        $params = [];

        // Filter logic can go here if needed

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveItem($data, $files)
    {
        // Clean data
        $validColumns = array_column($this->columns, 'name');
        foreach ($data as $key => $value) {
            if (!in_array($key, $validColumns) || $key === 'id') {
                unset($data[$key]);
            }
        }

        // Handle Image
        if ($url = $this->uploadImage($files)) {
            $data['image_url'] = $url;
        } else {
            return false; // Fail if image upload fails
        }

        // Insert
        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ':' . $f, $fields);
        $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function updateItem(array $data, $files): bool
    {
        // Handle Image if provided
        if (isset($files['image']) && $files['image']['error'] === UPLOAD_ERR_OK) {
            if ($url = $this->uploadImage($files)) {
                $data['image_url'] = $url;
            }
        }

        // Clean data (Remove fields not in DB columns, except _method)
        $validColumns = array_column($this->columns, 'name');
        $validColumns[] = 'image_url'; // Allow image_url manually

        $updateData = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $validColumns) && $key !== 'id') {
                $updateData[$key] = $value;
            }
        }

        if (empty($updateData)) return false;

        // Build SQL
        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($updateData)));
        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";

        // Add ID to params
        $updateData['id'] = $data['id'];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($updateData);
    }

    public function deleteItem(int $id): bool
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Helper to handle upload logic centrally
    private function uploadImage($files)
    {
        if (!isset($files['image']) || $files['image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $image = $files['image'];

        // *** FIX PATH: Go up to 'backend' then into 'public' ***
        // Current dir: src/resources/item
        // Target: public/storage/item
        $uploadDir = __DIR__ . '/../../../public/storage/item';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid() . '_' . basename($image['name']);
        $targetPath = $uploadDir . '/' . $filename;

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            return '/item/' . $filename;
        }
        return false;
    }
}
