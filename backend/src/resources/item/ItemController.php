<?php
require_once "../src/config/db.php";
require_once 'ItemModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class ItemController
{
    private $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    public function listItem($filters)
    {
        $items = $this->itemModel->listItem($filters);
        Response::json($items ?: []);
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
        // 1. Validate Required Fields
        foreach ($this->itemModel->columns as $column) {
            if ($column['name'] === 'id') continue;

            // Check if required field is missing
            if ($column['required'] && (!isset($data[$column['name']]) || trim($data[$column['name']]) === '')) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        // 2. Validate Image
        if (!isset($files['image']) || $files['image']['error'] !== UPLOAD_ERR_OK) {
            Response::json(['error' => "Image field is missing or invalid."], 400);
            return;
        }

        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $fileExtension = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            Response::json(['error' => "Image must be PNG, JPG, or JPEG."], 400);
            return;
        }

        // 3. Save
        $success = $this->itemModel->saveItem($data, $files);
        return $success
            ? Response::json(['message' => 'Item successfully created.'], 201)
            : Response::json(['error' => 'Database error during creation.'], 500);
    }

    public function updateItem($data, $files)
    {
        if (isset($data['id'])) {
            // FIX: Pass ($data, $files) to match Model signature
            $success = $this->itemModel->updateItem($data, $files);

            return $success
                ? Response::json(['message' => 'Item successfully updated.'], 200)
                : Response::json(['error' => 'Update failed.'], 500);
        } else {
            Response::json(['error' => 'Item ID is missing.'], 400);
        }
    }

    public function deleteItem($id)
    {
        if ($id) {
            $exists = $this->itemModel->getItem($id);
            if ($exists) {
                $success = $this->itemModel->deleteItem($id);
                return $success
                    ? Response::json(['message' => 'Item deleted.'], 200)
                    : Response::json(['error' => 'Delete failed.'], 500);
            } else {
                Response::json(['error' => 'Item not found.'], 404);
            }
        } else {
            Response::json(['error' => 'ID is required.'], 400);
        }
    }
}
