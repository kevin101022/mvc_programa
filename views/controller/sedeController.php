<?php

/**
 * SedeController - Gestión de peticiones para Sedes
 * Sigue principios de Clean Code y estandarización de respuestas JSON.
 */

require_once dirname(dirname(__DIR__)) . '/model/SedeModel.php';

class SedeController
{
    private $model;

    public function __construct()
    {
        // El modelo requiere parámetros en el constructor, los inicializamos nulos
        $this->model = new SedeModel(null, null);
    }

    /**
     * Punto de entrada principal para peticiones
     */
    public function handleRequest()
    {
        header('Content-Type: application/json');

        $action = $_GET['action'] ?? $_POST['action'] ?? 'list';

        try {
            switch ($action) {
                case 'list':
                    $this->index();
                    break;
                case 'get':
                    $this->show();
                    break;
                case 'create':
                    $this->store();
                    break;
                case 'update':
                    $this->update();
                    break;
                case 'delete':
                    $this->destroy();
                    break;
                default:
                    $this->sendResponse(['error' => 'Acción no válida'], 400);
            }
        } catch (Exception $e) {
            error_log("SedeController Error: " . $e->getMessage());
            $this->sendResponse(['error' => 'Error en el servidor', 'details' => $e->getMessage()], 500);
        } catch (Throwable $e) {
            error_log("SedeController Fatal Error: " . $e->getMessage());
            $this->sendResponse(['error' => 'Error fatal en el servidor', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener listado de todas las sedes
     */
    private function index()
    {
        $sedes = $this->model->readAll();
        $this->sendResponse($sedes);
    }

    /**
     * Obtener una sede específica por ID
     */
    private function show()
    {
        $id = $_GET['id'] ?? $_POST['id'] ?? null;
        if (!$id) {
            $this->sendResponse(['error' => 'ID de sede requerido'], 400);
            return;
        }

        $this->model->setSedeId($id);
        $result = $this->model->read();

        if (empty($result)) {
            $this->sendResponse(['error' => 'Sede no encontrada'], 404);
            return;
        }

        $this->sendResponse($result[0]);
    }

    /**
     * Crear una nueva sede
     */
    private function store()
    {
        $nombre = $_POST['sede_nombre'] ?? null;
        $foto = $this->handleFileUpload('sede_foto');

        if (!$nombre) {
            $this->sendResponse(['error' => 'El nombre de la sede es obligatorio'], 400);
            return;
        }

        $this->model->setSedeNombre($nombre);
        $this->model->setSedeFoto($foto);
        $id = $this->model->create();

        if ($id) {
            $this->sendResponse(['message' => 'Sede creada correctamente', 'id' => $id], 201);
        } else {
            $this->sendResponse(['error' => 'No se pudo crear la sede'], 500);
        }
    }

    /**
     * Actualizar una sede existente
     */
    private function update()
    {
        $id = $_POST['sede_id'] ?? null;
        $nombre = $_POST['sede_nombre'] ?? null;
        $foto = $this->handleFileUpload('sede_foto');

        if (!$id || !$nombre) {
            $this->sendResponse(['error' => 'ID y nombre son obligatorios'], 400);
            return;
        }

        $this->model->setSedeId($id);
        $this->model->setSedeNombre($nombre);

        // Si no se subió foto nueva, mantenemos la actual
        if (!$foto) {
            $current = $this->model->read();
            $foto = !empty($current) ? $current[0]['foto'] : null;
        }
        $this->model->setSedeFoto($foto);

        if ($this->model->update()) {
            $this->sendResponse(['message' => 'Sede actualizada correctamente']);
        } else {
            $this->sendResponse(['error' => 'No se pudo actualizar la sede'], 500);
        }
    }

    /**
     * Eliminar una sede
     */
    private function destroy()
    {
        // Soportamos ID por POST o GET para flexibilidad
        $id = $_POST['sede_id'] ?? $_GET['id'] ?? null;

        if (!$id) {
            $this->sendResponse(['error' => 'ID de sede requerido para eliminar'], 400);
            return;
        }

        $this->model->setSedeId($id);

        if ($this->model->delete()) {
            $this->sendResponse(['message' => 'Sede eliminada correctamente']);
        } else {
            $this->sendResponse(['error' => 'No se pudo eliminar la sede'], 500);
        }
    }

    /**
     * Helper para manejar la subida de archivos
     */
    private function handleFileUpload($fieldName)
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = '../../imagenes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExtension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('sede_') . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
            // Retornamos la ruta relativa para guardar en BD
            return '../../imagenes/' . $fileName;
        }

        return null;
    }

    /**
     * Helper para enviar respuestas JSON estandarizadas
     */
    private function sendResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

try {
    // Ejecutar el controlador
    $controller = new SedeController();
    $controller->handleRequest();
} catch (Throwable $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de inicialización del sistema',
        'details' => $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ], JSON_UNESCAPED_UNICODE);
}
