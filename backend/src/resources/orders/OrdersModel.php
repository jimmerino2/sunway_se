<?php
require_once '../src/config/db.php';

class OrdersModel
{
    private PDO $db;
    private string $tableName = 'orders';
    public array $columns = [
        ['name' => 'id', 'required' => true],
        ['name' => 'item_id', 'required' => true],
        ['name' => 'table_id', 'required' => true],
        ['name' => 'table_no', 'required' => true],
        ['name' => 'quantity', 'required' => true],
        ['name' => 'status', 'required' => true],
        ['name' => 'is_complete', 'required' => true],
    ];


    public function __construct()
    {
        $this->db = getPDO();
    }

    public function listOrders($filters = [])
    {
        $sql = "SELECT o.id, i.name AS 'item_name', c.name AS 'category_name', s.table_no, o.table_id, o.quantity, o.order_time, (i.price * o.quantity) as 'cost', o.status, o.is_complete FROM {$this->tableName} o
                JOIN item i ON i.id = o.item_id
                JOIN category c ON i.category_id = c.id
                JOIN seating s ON o.table_id = s.id
                WHERE 1=1";

        // Set conditions
        $params = [];
        if (!empty($filters)) {
            $validColumns = array_column($this->columns, 'name');
            foreach ($filters as $key => $value) {
                if (in_array($key, $validColumns)) {
                    switch ($key) {
                        case 'table_no':
                            $sql .= " AND s.$key = :$key"; 
                            break;
                        default:
                            $sql .= " AND o.$key = :$key"; 
                            break;
                    }
                    $params[$key] = $value;
                }
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrders($id)
    {
        $sql = "SELECT i.name AS 'item_name', c.name AS 'category_name', s.table_no, o.quantity, o.order_time, i.price, o.status FROM {$this->tableName} o
                JOIN item i ON i.id = o.item_id
                JOIN category c ON i.category_id = c.id
                JOIN seating s ON o.table_id = s.id
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveOrders($data)
    {
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

    public function updateOrders(array $data): bool
    {
        $setClause = implode(', ', array_map(fn($f) => "$f = :$f", array_keys($data)));

        $sql = "UPDATE {$this->tableName} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function clearOrdersByTable($tableId)
    {
        try {
            // This is the efficient query that uses the table_id
            $sql = "UPDATE orders 
                    SET is_complete = 'Y' 
                    WHERE is_complete = 'N' AND table_id = :table_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':table_id', $tableId);

            return $stmt->execute(); // Returns true on success, false on failure

        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log the error
            return false; // Return false on error
        }
    }

    public function deleteOrders(int $id): bool
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getRateOrders()
    {
        $sql = "SELECT DATE(order_time) AS day, COUNT(DISTINCT id) AS total
                FROM orders
                GROUP BY DATE(order_time)
                ORDER BY day;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRateIncome()
    {
        $sql = "SELECT DATE_FORMAT(order_time, '%Y-%m-%d') AS day, 
                    SUM(quantity * price) AS total
                FROM orders 
                JOIN item ON orders.item_id = item.id
                WHERE orders.is_complete = 'Y'
                GROUP BY DATE_FORMAT(order_time, '%Y-%m-%d')
                ORDER BY day;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
