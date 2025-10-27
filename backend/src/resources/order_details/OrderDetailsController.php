<?php
require_once "../src/config/db.php";
require_once 'OrderDetailsModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class OrderDetailsController
{
    private $orderDetailsModel;

    public function __construct()
    {
        $this->orderDetailsModel = new orderDetailsModel();
    }

    public function listOrderDetails($filters)
    {
        $orders = $this->orderDetailsModel->listOrderDetails($filters);
        if ($orders) {
            Response::json($orders);
        } else {
            Response::json(null);
        }
    }

    public function getOrderDetails($id)
    {
        $order = $this->orderDetailsModel->getOrderDetails($id);
        if ($order) {
            Response::json($order);
        } else {
            Response::json(['error' => 'Order details not found.'], 404);
        }
    }

    public function createOrderDetails($data)
    {
        // Ensure all required fields are filled
        foreach ($this->orderDetailsModel->columns as $column) {
            if ($column['name'] === 'id') {
                continue;
            }
            if ($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        $success = $this->orderDetailsModel->saveOrderDetails($data);
        return $success
            ? Response::json(['message' => 'Order details successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this order\'s details.'], 400);
    }

    public function updateOrderDetails($data)
    {
        if (isset($data['id'])) {
            $success = $this->orderDetailsModel->updateOrderDetails($data);
            return $success
                ? Response::json(['message' => 'Order details successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this order\' details.'], 400);
        } else {
            Response::json(['error' => 'Order details ID not set.'], 400);
        }
    }

    public function deleteOrderDetails($id)
    {
        if ($id != null) {
            $isOrderExist = $this->orderDetailsModel->getOrderDetails($id);

            if ($isOrderExist) {
                $success = $this->orderDetailsModel->deleteOrderDetails($id);
                return $success
                    ? Response::json(['message' => 'Order details successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this order\s details.'], 400);
            } else {
                Response::json(['error' => 'Order details does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'Order details ID not set.'], 400);
        }
    }
}
