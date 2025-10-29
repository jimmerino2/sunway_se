<?php
require_once '../src/config/db.php';

class ItemModel {
    private PDO $db;
    private string $tableName = 'item'; 
    public array $columns = [
        ['name' => 'id'         , 'required' => true    ],
        ['name' => 'name'       , 'required' => true    ],
        ['name' => 'desc'       , 'required' => false   ],
        ['name' => 'price'      , 'required' => true    ],
        ['name' => 'image_url'  , 'required' => true    ],
        ['name' => 'category_id', 'required' => true    ],
    ];


    public function __construct() {
        $this->db = getPDO();
    }

    public function listItem($filters = []) {
        $sql = "SELECT i.*, c.name AS 'category_name' FROM {$this->tableName} i JOIN category c ON i.category_id = c.id WHERE 1=1";

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

    public function getItem($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function saveItem($data) {
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
        return $stmt->execute($data);   
    }

    public function updateItem(array $data): bool {
        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($data)));

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function deleteItem(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
