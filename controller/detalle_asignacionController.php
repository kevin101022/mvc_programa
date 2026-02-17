<?php
require_once dirname(__DIR__) . '/model/DetalleAsignacionModel.php';

class DetalleAsignacionController
{
    public function index()
    {
        $asig_id = $_GET['asig_id'] ?? null;
        $model = new DetalleAsignacionModel(null, null, null, null);

        if ($asig_id) {
            $detalles = $model->readAllByAsignacion($asig_id);
        } else {
            $detalles = $model->getAll();
        }
        $this->sendResponse($detalles);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['asignacion_asig_id']) || !isset($data['detasig_hora_ini']) || !isset($data['detasig_hora_fin'])) {
            $this->sendResponse(['error' => 'Datos incompletos'], 400);
            return;
        }

        $model = new DetalleAsignacionModel($data['asignacion_asig_id'], $data['detasig_hora_ini'], $data['detasig_hora_fin'], null);
        $id = $model->create();
        if ($id) {
            $this->sendResponse(['message' => 'Detalle de asignación creado', 'id' => $id]);
        } else {
            $this->sendResponse(['error' => 'Error al crear'], 500);
        }
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->sendResponse(['error' => 'ID de detalle requerido'], 400);
            return;
        }
        $model = new DetalleAsignacionModel(null, null, null, $id);
        $detalle = $model->readByDetalleId($id); // Needs implementation in model or use read()
        $this->sendResponse($detalle ? $detalle : ['error' => 'No encontrado'], $detalle ? 200 : 404);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['detasig_id'])) {
            $this->sendResponse(['error' => 'ID de detalle requerido'], 400);
            return;
        }

        $model = new DetalleAsignacionModel($data['asignacion_asig_id'], $data['detasig_hora_ini'], $data['detasig_hora_fin'], $data['detasig_id']);
        if ($model->update()) {
            $this->sendResponse(['message' => 'Detalle actualizado']);
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
        $model = new DetalleAsignacionModel(null, null, null, $id);
        if ($model->delete()) {
            $this->sendResponse(['message' => 'Detalle eliminado']);
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
