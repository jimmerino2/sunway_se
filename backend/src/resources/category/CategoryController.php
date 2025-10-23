<?php
require_once "../src/config/db.php";
require_once 'CategoryModel.php';
require_once DIR_BACKEND . '\utils\Response.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new categoryModel();
    }

    public function listCategory($filters) {
        $categories = $this->categoryModel->listCategory($filters);
        if ($categories) {
            Response::json($categories);
        } else {
            Response::json(null);
        }
    }

    public function getCategory($id) {
        $category = $this->categoryModel->getCategory($id);
        if ($category) {
            Response::json($category);
        } else {
            Response::json(['error' => 'Category not found.'], 404);
        }
    }

    public function createCategory($data) {
        // Ensure all required fields are filled
        foreach ($this->categoryModel->columns as $column) {
            if($column['name'] === 'id') {continue;}
            if($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);   
                return;
            }
        }

        // Check for unique category 
        $isEmailTaken = $this->categoryModel->checkUniqueName(0, $data['name']);
        if($isEmailTaken){
            Response::json(['error' => 'There is already a category with this name.'], 400);   
            return;
        }

        $success = $this->categoryModel->saveCategory($data);
        return $success
            ? Response::json(['message' => 'Category successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this category.'], 400);
    }

    public function updateCategory($data) {
        if(isset($data['id'])){
            // Check for unique category 
            $isEmailTaken = $this->categoryModel->checkUniqueName($data['id'], $data['name']);
            if($isEmailTaken){
                Response::json(['error' => 'There is already a category with this name.'], 400);   
                return;
            }

            $success = $this->categoryModel->updateCategory($data);
            return $success
                ? Response::json(['message' => 'Category successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this category.'], 400);
        } else {
            Response::json(['error' => 'Category ID not set.'], 400);
        }
    }

    public function deleteCategory($id) {
        if($id != null){
            $isCategoryExist = $this->categoryModel->getCategory($id);

            if($isCategoryExist){
                $success = $this->categoryModel->deleteCategory($id);
                return $success
                    ? Response::json(['message' => 'Category successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this category.'], 400);
            } else {
                Response::json(['error' => 'Category does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'Category ID not set.'], 400);
        }
    }
}
