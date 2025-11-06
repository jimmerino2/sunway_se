<?php
require_once '../src/config/db.php';

class OrdersModel {
    private PDO $db;
    private string $tableName = 'orders'; 
    public array $columns = [
        ['name' => 'id'         , 'required' => true    ],
        ['name' => 'item_id'    , 'required' => true    ],
        ['name' => 'table_id'   , 'required' => true    ],
        ['name' => 'quantity'   , 'required' => true    ],
        ['name' => 'status'     , 'required' => true    ], 
    ];


    public function __construct() {
        $this->db = getPDO();
    }

    public function listOrders($filters = []) {
        $sql = "SELECT o.id, i.name AS 'item_name', c.name AS 'category_name', s.table_no, o.quantity, o.order_time, (i.price * o.quantity) as 'cost', o.status FROM {$this->tableName} o
                JOIN item i ON i.id = o.item_id
                JOIN category c ON i.category_id = c.id
                JOIN seating s ON o.table_id = s.id
                WHERE 1=1";

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

    public function getOrders($id) {
        $sql = "SELECT i.name AS 'item_name', c.name AS 'category_name', s.table_no, o.quantity, o.order_time, i.price, o.status FROM {$this->tableName} o
                JOIN item i ON i.id = o.item_id
                JOIN category c ON i.category_id = c.id
                JOIN seating s ON o.table_id = s.id
                WHERE i.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function saveOrders($data) {
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

    public function updateOrders(array $data): bool {
        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($data)));

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function deleteOrders(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getRateOrders() {
        $sql = "SELECT DATE(order_time) AS day, COUNT(DISTINCT order_time) AS total
                FROM orders
                GROUP BY DATE(order_time)
                ORDER BY day;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRateIncome() {
        $sql = "SELECT MONTH(order_time) AS month, SUM(quantity * price) AS total
                FROM orders JOIN item ON orders.item_id = item.id
                GROUP BY MONTH(order_time)
                ORDER BY month;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
