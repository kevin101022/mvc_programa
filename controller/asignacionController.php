<?php
require_once dirname(__DIR__) . '/model/AsignacionModel.php';

class AsignacionController
{
    public function index()
    {
        $model = new AsignacionModel(null, null, null, null, null, null, null);
        $asignaciones = $model->readAll();
        $this->sendResponse($asignaciones);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['instructor_inst_id']) || !isset($data['asig_fecha_ini']) || !isset($data['asig_fecha_fin']) || !isset($data['ficha_fich_id'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new AsignacionModel(
            null,
            $data['instructor_inst_id'],
            $data['asig_fecha_ini'],
            $data['asig_fecha_fin'],
            $data['ficha_fich_id'],
            $data['ambiente_amb_id'],
            $data['competencia_comp_id']
        );

        $id = $model->create();
        if ($id) {
            $this->sendResponse(['message' => 'Asignación creada', 'id' => $id]);
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
        $model = new AsignacionModel($id, null, null, null, null, null, null);
        $asig = $model->read();
        $this->sendResponse($asig[0] ?? ['error' => 'No encontrada'], $asig ? 200 : 404);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['asig_id'])) {
            $this->sendResponse(['error' => 'ID requerido'], 400);
            return;
        }

        $model = new AsignacionModel(
            $data['asig_id'],
            $data['instructor_inst_id'],
            $data['asig_fecha_ini'],
            $data['asig_fecha_fin'],
            $data['ficha_fich_id'],
            $data['ambiente_amb_id'],
            $data['competencia_comp_id']
        );

        if ($model->update()) {
            $this->sendResponse(['message' => 'Asignación actualizada']);
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
        $model = new AsignacionModel($id, null, null, null, null, null, null);
        if ($model->delete()) {
            $this->sendResponse(['message' => 'Asignación eliminada']);
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
