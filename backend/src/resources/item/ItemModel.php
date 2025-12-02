<?php
require_once '../src/config/db.php';

class ItemModel
{
    private PDO $db;
    private string $tableName = 'item';

    public array $columns = [
        ['name' => 'id', 'required' => true],
        ['name' => 'name', 'required' => true],
        ['name' => 'description', 'required' => false],
        ['name' => 'price', 'required' => true],
        ['name' => 'category_id', 'required' => true],
        ['name' => 'active', 'required' => false],
        ['name' => 'image_url', 'required' => false],
    ];


    public function __construct()
    {
        $this->db = getPDO();
    }

    // --- Retrieve Methods ---

    public function listItem($filters = [])
    {
        // This query returns all items unless explicit filters (like 'active', 'category_id', etc.) are provided.
        $sql = "SELECT i.*, c.name AS 'category_name' FROM {$this->tableName} i JOIN category c ON i.category_id = c.id WHERE 1=1";

        $params = [];
        if (!empty($filters)) {
            $validColumns = array_column($this->columns, 'name');
            foreach ($filters as $key => $value) {
                if (in_array($key, $validColumns)) {
                    $sql .= " AND i.$key = :$key";
                    $params[$key] = $value;
                }
            }
        }

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

    // --- CRUD Helper Methods ---

    private function getCategoryName($category_id)
    {
        $sql = "SELECT name FROM category WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Clean category name for filename
        return $result ? strtolower(str_replace([' ', '/', '\\'], '_', $result['name'])) : 'uncategorized';
    }

    public function uploadImage($files, $itemName, $categoryName)
    {
        if (isset($files['image'])) {
            $image = $files['image'];
            if ($image['error'] === UPLOAD_ERR_OK) {

                $uploadDir = dirname(dirname(dirname(__DIR__))) . '/public/storage/item';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

                // FILENAME CONSTRUCTION: category_name_item_name.ext
                $cleanItemName = strtolower(str_replace([' ', '/', '\\'], '_', $itemName));

                $baseFilename = "{$categoryName}_{$cleanItemName}";
                $filename = "{$baseFilename}.{$fileExtension}";
                $targetPath = $uploadDir . '/' . $filename;

                // Ensure filename is unique (append counter)
                $i = 1;
                while (file_exists($targetPath)) {
                    $filename = "{$baseFilename}_{$i}.{$fileExtension}";
                    $targetPath = $uploadDir . '/' . $filename;
                    $i++;
                }

                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    return '/item/' . $filename;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    // --- CRUD Methods ---

    public function saveItem($data, $files)
    {
        $categoryName = $this->getCategoryName($data['category_id']);
        $data['image_url'] = $this->uploadImage($files, $data['name'], $categoryName);

        if ($data['image_url']) {
            $validColumns = array_column($this->columns, 'name');
            $dataToInsert = array_filter($data, fn($key) => in_array($key, $validColumns) && $key !== 'id', ARRAY_FILTER_USE_KEY);

            $fields = array_keys($dataToInsert);
            $placeholders = array_map(fn($f) => ':' . $f, $fields);

            $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute($dataToInsert);
        }
        return false;
    }

    public function updateItem(array $data, $files): bool
    {
        // Handle Image Update
        if (isset($files['image']) && $files['image']['error'] === UPLOAD_ERR_OK) {

            // Fetch necessary data for filename if not provided in $data
            $existingItem = $this->getItem($data['id']);
            $itemName = $data['name'] ?? $existingItem['name'] ?? 'unknown_item';
            $categoryId = $data['category_id'] ?? $existingItem['category_id'] ?? 0;
            $categoryName = $this->getCategoryName($categoryId);

            $newImageUrl = $this->uploadImage($files, $itemName, $categoryName);
            if ($newImageUrl) {
                $data['image_url'] = $newImageUrl;
            }
        }

        // Filter data and prepare SET clause
        $validColumns = array_column($this->columns, 'name');
        $dataToUpdate = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $validColumns) && $key !== 'id') {
                $dataToUpdate[$key] = $value;
            }
        }

        if (empty($dataToUpdate)) {
            return false;
        }

        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($dataToUpdate)));
        $dataToUpdate['id'] = $data['id'];

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($dataToUpdate);
    }

    public function deleteItem(int $id): bool
    {
        // SOFT DELETE: Sets 'active' to 0 (Deactivate)
        // Note: The controller/JS now sends 'active=1' via PATCH to reactivate items.
        $sql = "UPDATE {$this->tableName} SET active = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
