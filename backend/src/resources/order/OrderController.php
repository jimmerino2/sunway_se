<?php
require_once "../src/config/db.php";
require_once 'OrderModel.php';
require_once DIR_BACKEND . '\utils\Response.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new orderModel();
    }

    public function listOrder($filters) {
        $orders = $this->orderModel->listOrder($filters);
        if ($orders) {
            Response::json($orders);
        } else {
            Response::json(null);
        }
    }

    public function getOrder($id) {
        $order = $this->orderModel->getOrder($id);
        if ($order) {
            Response::json($order);
        } else {
            Response::json(['error' => 'Order not found.'], 404);
        }
    }

    public function createOrder($data) {
        // Ensure all required fields are filled
        foreach ($this->orderModel->columns as $column) {
            if($column['name'] === 'id') {continue;}
            if($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);   
                return;
            }
        }

        $success = $this->orderModel->saveOrder($data);
        return $success
            ? Response::json(['message' => 'Order successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this order.'], 400);
    }

    public function updateOrder($data) {
        if(isset($data['id'])){
            $success = $this->orderModel->updateOrder($data);
            return $success
                ? Response::json(['message' => 'Order successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this order.'], 400);
        } else {
            Response::json(['error' => 'Order ID not set.'], 400);
        }
    }

    public function deleteOrder($id) {
        if($id != null){
            $isOrderExist = $this->orderModel->getOrder($id);

            if($isOrderExist){
                $success = $this->orderModel->deleteOrder($id);
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
}
