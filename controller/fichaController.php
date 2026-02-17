<?php
require_once dirname(__DIR__) . '/model/FichaModel.php';

class FichaController
{
    public function index()
    {
        $model = new FichaModel(null, null, null, null, null);
        $fichas = $model->readAll();
        $this->sendResponse($fichas);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['programa_prog_id']) || !isset($data['instructor_inst_id']) || !isset($data['fich_jornada']) || !isset($data['coordinacion_id'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new FichaModel($data['fich_id'], $data['programa_prog_id'], $data['instructor_inst_id'], $data['fich_jornada'], $data['coordinacion_id']);
        $id = $model->create();
        if ($id) {
            $this->sendResponse(['message' => 'Ficha creada', 'id' => $id]);
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
        $model = new FichaModel($id, null, null, null);
        $ficha = $model->read();
        $this->sendResponse($ficha[0] ?? ['error' => 'No encontrada'], $ficha ? 200 : 404);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['fich_id']) || !isset($data['programa_prog_id']) || !isset($data['instructor_inst_id']) || !isset($data['fich_jornada']) || !isset($data['coordinacion_id'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new FichaModel($data['fich_id'], $data['programa_prog_id'], $data['instructor_inst_id'], $data['fich_jornada'], $data['coordinacion_id']);
        if ($model->update()) {
            $this->sendResponse(['message' => 'Ficha actualizada']);
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
        $model = new FichaModel($id, null, null, null, null);
        if ($model->delete()) {
            $this->sendResponse(['message' => 'Ficha eliminada']);
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
