<?php
require_once "../src/config/db.php";
require_once 'OrdersModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class OrdersController
{
    private $ordersModel;

    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
    }

    public function listOrders($filters)
    {
        $orders = $this->ordersModel->listOrders($filters);
        if ($orders) {
            Response::json($orders);
        } else {
            Response::json(null);
        }
    }

    public function getOrders($id)
    {
        $order = $this->ordersModel->getOrders($id);
        if ($order) {
            Response::json($order);
        } else {
            Response::json(['error' => 'Order not found.'], 404);
        }
    }

    public function createOrders($data)
    {
        // Ensure all required fields are filled
        foreach ($this->ordersModel->columns as $column) {
            if ($column['name'] === 'id') {
                continue;
            }
            if ($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        $success = $this->ordersModel->saveOrders($data);
        return $success
            ? Response::json(['message' => 'Order successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this order.'], 400);
    }

    public function updateOrders($data)
    {
        if (isset($data['id'])) {
            $success = $this->ordersModel->updateOrders($data);
            return $success
                ? Response::json(['message' => 'Order successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this order.'], 400);
        } else {
            Response::json(['error' => 'Order ID not set.'], 400);
        }
    }

    public function deleteOrders($id)
    {
        if ($id != null) {
            $isOrderExist = $this->ordersModel->getOrders($id);

            if ($isOrderExist) {
                $success = $this->ordersModel->deleteOrders($id);
                return $success
                    ? Response::json(['message' => 'Order successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this order.'], 400);
            } else {
                Response::json(['error' => 'Order does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'Order ID not set.'], 400);
        }
    }

    public function getRateOrders() {
        $data = $this->ordersModel->getRateOrders();
        Response::json($data);
    }
    
    public function getRateIncome() {
        $data = $this->ordersModel->getRateIncome();
        Response::json($data);
    }
}
