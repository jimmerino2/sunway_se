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
        // 🌟 ADMIN FIX: NO DEFAULT FILTER APPLIED HERE.
        // If $filters is empty, ItemModel::listItem runs a SELECT * query, returning all items (active=1 or active=0).

        $items = $this->itemModel->listItem($filters);

        if ($items) {
            Response::json($items);
        } else {
            // Return empty array instead of null for consistency if no items found
            Response::json([]);
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
        // Fields that must be present and not empty
        $required_fields = ['name', 'price', 'category_id', 'description'];

        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                Response::json(['error' => ucfirst($field) . " field is missing or empty."], 400);
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

        // Add 'active' = 1 by default when creating
        $data['active'] = 1;

        $success = $this->itemModel->saveItem($data, $files);
        return $success
            ? Response::json(['message' => 'Item successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this item.'], 400);
    }

    public function updateItem($data, $files = [])
    {
        // Check for ID presence
        if (!isset($data['id'])) {
            Response::json(['error' => 'Item ID not set.'], 400);
            return;
        }

        $id = $data['id'];

        // Check if the item exists
        if (!$this->itemModel->getItem($id)) {
            Response::json(['error' => 'Item does not exist.'], 404);
            return;
        }

        $success = $this->itemModel->updateItem($data, $files);

        return $success
            ? Response::json(['message' => 'Item successfully updated.'], 200)
            : Response::json(['error' => 'There was an issue updating this item.'], 400);
    }

    public function deleteItem($id)
    {
        // DELETE MODIFICATION: Still performs soft delete via UPDATE in the Model.
        if ($id === null) {
            Response::json(['error' => 'Item ID not set.'], 400);
            return;
        }

        $isItemExist = $this->itemModel->getItem($id);

        if ($isItemExist) {
            // This method now calls ItemModel::deleteItem, which sets active = 0.
            $success = $this->itemModel->deleteItem($id);
            return $success
                ? Response::json(['message' => 'Item successfully deactivated (soft deleted).'], 200)
                : Response::json(['error' => 'There was an issue deactivating this item.'], 400);
        } else {
            Response::json(['error' => 'Item does not exist.'], 404);
        }
    }
}
