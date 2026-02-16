<?php
require_once dirname(__DIR__) . '/model/InstructorModel.php';
require_once dirname(__DIR__) . '/model/SedeModel.php';

class instructorController
{
    public function index()
    {
        $model = new InstructorModel();
        $instructores = $model->readAll();
        return $this->sendResponse($instructores);
    }

    public function getSedes()
    {
        $model = new SedeModel();
        $sedes = $model->readAll();
        return $this->sendResponse($sedes);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            return $this->sendResponse(['error' => 'No se recibieron datos'], 400);
        }

        $model = new InstructorModel(
            null,
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id']
        );

        $id = $model->create();
        if ($id) {
            return $this->sendResponse(['message' => 'Instructor creado correctamente', 'id' => $id]);
        }
        return $this->sendResponse(['error' => 'Error al crear el instructor'], 500);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return $this->sendResponse(['error' => 'ID no proporcionado'], 400);
        }

        $model = new InstructorModel($id);
        $instructor = $model->read();

        if ($instructor) {
            return $this->sendResponse($instructor[0]);
        }
        return $this->sendResponse(['error' => 'Instructor no encontrado'], 404);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['inst_id'])) {
            return $this->sendResponse(['error' => 'Datos incompletos'], 400);
        }

        $model = new InstructorModel(
            $data['inst_id'],
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id']
        );

        if ($model->update()) {
            return $this->sendResponse(['message' => 'Instructor actualizado correctamente']);
        }
        return $this->sendResponse(['error' => 'Error al actualizar el instructor'], 500);
    }

    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return $this->sendResponse(['error' => 'ID no proporcionado'], 400);
        }

        $model = new InstructorModel($id);
        if ($model->delete()) {
            return $this->sendResponse(['message' => 'Instructor eliminado correctamente']);
        }
        return $this->sendResponse(['error' => 'Error al eliminar el instructor'], 500);
    }

    private function sendResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
