<?php
require_once "../src/config/db.php";
require_once 'SeatingModel.php';
require_once __DIR__ . '/../../utils/Response.php';

class SeatingController
{
    private $seatingModel;

    public function __construct()
    {
        $this->seatingModel = new seatingModel();
    }

    public function listSeating($filters)
    {
        $seatings = $this->seatingModel->listSeating($filters);
        if ($seatings) {
            Response::json($seatings);
        } else {
            Response::json(null);
        }
    }

    public function getSeating($id)
    {
        $seating = $this->seatingModel->getSeating($id);
        if ($seating) {
            Response::json($seating);
        } else {
            Response::json(['error' => 'Seating not found.'], 404);
        }
    }

    public function createSeating($data)
    {
        // Ensure all required fields are filled
        foreach ($this->seatingModel->columns as $column) {
            if ($column['name'] === 'id') {
                continue;
            }
            if ($column['required'] && !in_array($column['name'], array_keys($data))) {
                Response::json(['error' => ucfirst($column['name']) . " field is missing."], 400);
                return;
            }
        }

        // Check for unique seating 
        $isTableNoTaken = $this->seatingModel->checkUniqueTableNo(0, $data['table_no']);
        if ($isTableNoTaken) {
            Response::json(['error' => 'There is already a seating with this table number.'], 400);
            return;
        }

        $success = $this->seatingModel->saveSeating($data);
        return $success
            ? Response::json(['message' => 'Seating successfully created.'], 201)
            : Response::json(['error' => 'There was an issue creating this seating.'], 400);
    }

    public function updateSeating($data)
    {
        if (isset($data['id'])) {
            // Check for unique seating 
            $isTableNoTaken = $this->seatingModel->checkUniqueTableNo($data['id'], $data['table_no']);
            if ($isTableNoTaken) {
                Response::json(['error' => 'There is already a seating with this table number.'], 400);
                return;
            }

            $success = $this->seatingModel->updateSeating($data);
            return $success
                ? Response::json(['message' => 'Seating successfully updated.'], 201)
                : Response::json(['error' => 'There was an issue updating this seating.'], 400);
        } else {
            Response::json(['error' => 'Seating ID not set.'], 400);
        }
    }

    public function deleteSeating($id)
    {
        if ($id != null) {
            $isSeatingExist = $this->seatingModel->getSeating($id);

            if ($isSeatingExist) {
                $success = $this->seatingModel->deleteSeating($id);
                return $success
                    ? Response::json(['message' => 'Seating successfully deleted.'], 201)
                    : Response::json(['error' => 'There was an issue deleting this seating.'], 400);
            } else {
                Response::json(['error' => 'Seating does not exist.'], 400);
            }
        } else {
            Response::json(['error' => 'Seating ID not set.'], 400);
        }
    }
}
