<?php
require_once dirname(__DIR__) . '/model/CoordinacionModel.php';

class CoordinacionController
{
    public function index()
    {
        $model = new CoordinacionModel();
        $coordinaciones = $model->getAll();
        $this->sendResponse($coordinaciones);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['coord_nombre']) || !isset($data['centro_formacion_cent_id'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new CoordinacionModel(null, $data['coord_nombre'], $data['centro_formacion_cent_id']);
        $id = $model->create();
        if ($id) {
            $this->sendResponse(['message' => 'Coordinación creada', 'id' => $id]);
        } else {
            $this->sendResponse(['error' => 'Error al crear'], 500);
        }
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->sendResponse(['error' => 'ID requerido'], 400);
            return;
        }
        $model = new CoordinacionModel($id);
        $coord = $model->read();
        $this->sendResponse($coord[0] ?? ['error' => 'No encontrado'], $coord ? 200 : 404);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['coord_id']) || !isset($data['coord_nombre']) || !isset($data['centro_formacion_cent_id'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new CoordinacionModel($data['coord_id'], $data['coord_nombre'], $data['centro_formacion_cent_id']);
        if ($model->update()) {
            $this->sendResponse(['message' => 'Coordinación actualizada']);
        } else {
            $this->sendResponse(['error' => 'Error al actualizar'], 500);
        }
    }

    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->sendResponse(['error' => 'ID requerido'], 400);
            return;
        }
        $model = new CoordinacionModel($id);
        if ($model->delete()) {
            $this->sendResponse(['message' => 'Coordinación eliminada']);
        } else {
            $this->sendResponse(['error' => 'Error al eliminar'], 500);
        }
    }

    private function sendResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
