<?php

/**
 * ProgramaController - Gestión de peticiones para Programas
 */

require_once dirname(__DIR__) . '/model/ProgramaModel.php';
require_once dirname(__DIR__) . '/model/TituloProgramaModel.php';

class ProgramaController
{
    private $model;
    private $tituloModel;

    public function __construct()
    {
        $this->model = new ProgramaModel();
        $this->tituloModel = new TituloProgramaModel();
    }

    /**
     * Obtener listado de todos los programas
     */
    public function index()
    {
        $programas = $this->model->readAll();
        $this->sendResponse($programas);
    }

    /**
     * Obtener los títulos de programa para dropdowns
     */
    public function getTitulos()
    {
        $titulos = $this->tituloModel->readAll();
        $this->sendResponse($titulos);
    }

    /**
     * Obtener un programa específico por ID
     */
    public function show($id = null)
    {
        if (!$id) {
            $this->sendResponse(['error' => 'ID de programa requerido'], 400);
            return;
        }

        $this->model->setProgId($id);
        $result = $this->model->read();

        if (empty($result)) {
            $this->sendResponse(['error' => 'Programa no encontrado'], 404);
            return;
        }

        $programa = $result[0];
        $programa['competencias'] = $this->model->getCompetenciasByPrograma();
        $this->sendResponse($programa);
    }

    /**
     * Crear un nuevo programa
     */
    public function store()
    {
        try {
            $codigo = $_POST['prog_codigo'] ?? null;
            $denominacion = $_POST['prog_denominacion'] ?? null;
            $tit_id = $_POST['tit_programa_titpro_id'] ?? null;
            $tipo = $_POST['prog_tipo'] ?? null;
            $sede_id = $_POST['sede_sede_id'] ?? null;

            if (!$codigo || !$denominacion || !$tit_id) {
                $this->sendResponse(['error' => 'Faltan campos obligatorios'], 400);
                return;
            }

            $this->model->setProgCodigo($codigo);
            $this->model->setProgDenominacion($denominacion);
            $this->model->setTitProgramaTitproId($tit_id);
            $this->model->setProgTipo($tipo);
            $this->model->setSedeSedeId($sede_id);

            $id = $this->model->create();

            if ($id) {
                $this->sendResponse(['message' => 'Programa creado correctamente', 'id' => $id], 201);
            } else {
                $this->sendResponse(['error' => 'No se pudo crear el programa'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['error' => 'Error al crear el programa', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar un programa existente
     */
    public function update()
    {
        try {
            $id = $_POST['prog_id'] ?? null;
            $codigo = $_POST['prog_codigo'] ?? null;
            $denominacion = $_POST['prog_denominacion'] ?? null;
            $tit_id = $_POST['tit_programa_titpro_id'] ?? null;
            $tipo = $_POST['prog_tipo'] ?? null;
            $sede_id = $_POST['sede_sede_id'] ?? null;

            if (!$id || !$codigo || !$denominacion || !$tit_id) {
                $this->sendResponse(['error' => 'Faltan campos obligatorios'], 400);
                return;
            }

            $this->model->setProgId($id);
            $this->model->setProgCodigo($codigo);
            $this->model->setProgDenominacion($denominacion);
            $this->model->setTitProgramaTitproId($tit_id);
            $this->model->setProgTipo($tipo);
            $this->model->setSedeSedeId($sede_id);

            if ($this->model->update()) {
                $this->sendResponse(['message' => 'Programa actualizado correctamente']);
            } else {
                $this->sendResponse(['error' => 'No se pudo actualizar el programa'], 500);
            }
        } catch (Exception $e) {
            $this->sendResponse(['error' => 'Error al actualizar el programa', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar un programa
     */
    public function destroy($id = null)
    {
        try {
            if (!$id) {
                $this->sendResponse(['error' => 'ID de programa requerido'], 400);
                return;
            }

            $this->model->setProgId($id);

            if ($this->model->delete()) {
                $this->sendResponse(['message' => 'Programa eliminado correctamente']);
            } else {
                $this->sendResponse(['error' => 'No se pudo eliminar el programa'], 500);
            }
        } catch (Exception $e) {
            $message = 'Error al eliminar el programa: ' . $e->getMessage();
            // pgsql foreign key violation check could be added here if needed
            $this->sendResponse(['error' => $message], 500);
        }
    }

    /**
     * Helper para enviar respuestas JSON
     */
    private function sendResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
