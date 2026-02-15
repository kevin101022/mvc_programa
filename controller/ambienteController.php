<?php

/**
 * AmbienteController - Gestión de peticiones para Ambientes
 */

require_once dirname(__DIR__) . '/model/AmbienteModel.php';
require_once dirname(__DIR__) . '/model/SedeModel.php';

class AmbienteController
{
    private $model;

    public function __construct()
    {
        $this->model = new AmbienteModel(null, null, null);
    }

    /**
     * Obtener listado de todos los ambientes
     * Si se pasa sede_id, filtra por esa sede
     */
    public function index($sede_id = null)
    {
        if ($sede_id) {
            $this->model->setSedeSedeId($sede_id);
            $ambientes = $this->model->read();
        } else {
            $ambientes = $this->model->readAll();
        }
        $this->sendResponse($ambientes);
    }

    /**
     * Obtener un ambiente específico por ID
     */
    public function show($id = null)
    {
        if (!$id) {
            $this->sendResponse(['error' => 'ID de ambiente requerido'], 400);
            return;
        }

        $ambiente = $this->model->readById($id);

        if (!$ambiente) {
            $this->sendResponse(['error' => 'Ambiente no encontrado'], 404);
            return;
        }

        $this->sendResponse($ambiente);
    }

    /**
     * Crear un nuevo ambiente
     */
    public function store()
    {
        $nombre = $_POST['amb_nombre'] ?? null;
        $sede_id = $_POST['sede_sede_id'] ?? null;

        if (!$nombre || !$sede_id) {
            $this->sendResponse(['error' => 'Nombre y Sede son obligatorios'], 400);
            return;
        }

        $this->model->setAmbnombre($nombre);
        $this->model->setSedeSedeId($sede_id);
        $id = $this->model->create();

        if ($id) {
            $this->sendResponse(['message' => 'Ambiente creado correctamente', 'id' => $id], 201);
        } else {
            $this->sendResponse(['error' => 'No se pudo crear el ambiente'], 500);
        }
    }

    /**
     * Actualizar un ambiente existente
     */
    public function update()
    {
        $id = $_POST['amb_id'] ?? null;
        $nombre = $_POST['amb_nombre'] ?? null;
        $sede_id = $_POST['sede_sede_id'] ?? null;

        if (!$id || !$nombre || !$sede_id) {
            $this->sendResponse(['error' => 'ID, Nombre y Sede son obligatorios'], 400);
            return;
        }

        $this->model->setAmbId($id);
        $this->model->setAmbnombre($nombre);
        $this->model->setSedeSedeId($sede_id);

        if ($this->model->update()) {
            $this->sendResponse(['message' => 'Ambiente actualizado correctamente']);
        } else {
            $this->sendResponse(['error' => 'No se pudo actualizar el ambiente'], 500);
        }
    }

    /**
     * Eliminar un ambiente
     */
    public function destroy($id = null)
    {
        if (!$id) {
            $this->sendResponse(['error' => 'ID requerido para eliminar'], 400);
            return;
        }

        $this->model->setAmbId($id);

        if ($this->model->delete()) {
            $this->sendResponse(['message' => 'Ambiente eliminado correctamente']);
        } else {
            $this->sendResponse(['error' => 'No se pudo eliminar el ambiente'], 500);
        }
    }

    /**
     * Helper para enviar respuestas JSON estandarizadas
     */
    private function sendResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
