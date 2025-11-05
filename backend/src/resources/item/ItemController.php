<?php
require_once "../src/config/db.php";
require_once 'ItemModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class ItemController
{
    private $itemModel;

    public function __construct()
    {
        $this->itemModel = new itemModel();
    }

    public function listItem($filters)
    {
        $items = $this->itemModel->listItem($filters);
        if ($items) {
            Response::json($items);
        } else {
            Response::json(null);
        }
    }

    public function getItem($id)
    {
        $item = $this->itemModel->getItem($id);
        if ($item) {
            Response::json($item);
        } else {
            Response::json(['error' => 'Item not found.'], 404);
        }
    }

    public function createItem($data, $files)
    {
        // Ensure all required fields are filled
        foreach ($this->itemModel->columns as $column) {
            if ($column['name'] === 'id') {
                continue;
            }
            if ($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        // Ensure image file is correct
        if (!isset(($files['image']))) {
            Response::json(['error' => "Image field is missing."], 400);
            return;
        }
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $fileExtension = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            Response::json(['error' => "Image uploaded is not in the correct format."], 400);
            return;
        }

        $success = $this->itemModel->saveItem($data, $files);
        return $success
            ? Response::json(['message' => 'Item successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this item.'], 400);
    }

    public function updateItem($data)
    {
        if (isset($data['id'])) {
            $success = $this->itemModel->updateItem($data);
            return $success
                ? Response::json(['message' => 'Item successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this item.'], 400);
        } else {
            Response::json(['error' => 'Item ID not set.'], 400);
        }
    }

    public function deleteItem($id)
    {
        if ($id != null) {
            $isItemExist = $this->itemModel->getItem($id);

            if ($isItemExist) {
                $success = $this->itemModel->deleteItem($id);
                return $success
                    ? Response::json(['message' => 'Item successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this item.'], 400);
            } else {
                Response::json(['error' => 'Item does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'Item ID not set.'], 400);
        }
    }
}
