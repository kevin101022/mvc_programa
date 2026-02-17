<?php
require_once dirname(__DIR__) . '/Conexion.php';

class CompetenciaProgramaModel
{
    private $programa_prog_id;
    private $competencia_comp_id;
    private $db;

    public function __construct($programa_prog_id = null, $competencia_comp_id = null)
    {
        $this->setProgramaProgId($programa_prog_id);
        $this->setCompetenciaCompId($competencia_comp_id);
        $this->db = Conexion::getConnect();
    }

    // Getters 
    public function getProgramaProgId()
    {
        return $this->programa_prog_id;
    }
    public function getCompetenciaCompId()
    {
        return $this->competencia_comp_id;
    }

    // Setters 
    public function setProgramaProgId($programa_prog_id)
    {
        $this->programa_prog_id = $programa_prog_id;
    }
    public function setCompetenciaCompId($competencia_comp_id)
    {
        $this->competencia_comp_id = $competencia_comp_id;
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
                  VALUES (:programa_prog_id, :competencia_comp_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':competencia_comp_id', $this->competencia_comp_id);
        return $stmt->execute();
    }

    public function read()
    {
        $sql = "SELECT * FROM competxprograma WHERE PROGRAMA_prog_id = :programa_prog_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':programa_prog_id' => $this->programa_prog_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM competxprograma";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE competxprograma SET COMPETENCIA_comp_id = :competencia_comp_id 
                  WHERE PROGRAMA_prog_id = :programa_prog_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':competencia_comp_id', $this->competencia_comp_id);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM competxprograma WHERE PROGRAMA_prog_id = :programa_prog_id 
                  AND COMPETENCIA_comp_id = :competencia_comp_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':competencia_comp_id', $this->competencia_comp_id);
        return $stmt->execute();
    }

    // Extended functionality for refactoring
    public function getProgramasByCompetencia($compId)
    {
        $sql = "SELECT p.*, t.titpro_nombre 
                FROM programa p
                INNER JOIN competxprograma cp ON p.prog_id = cp.programa_prog_id
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                WHERE cp.competencia_comp_id = :comp_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':comp_id' => $compId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompetenciasByPrograma($progId)
    {
        $sql = "SELECT c.* 
                FROM competencia c
                INNER JOIN competxprograma cp ON c.comp_id = cp.competencia_comp_id
                WHERE cp.programa_prog_id = :prog_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':prog_id' => $progId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function syncProgramas($compId, $programaIds)
    {
        try {
            $this->db->beginTransaction();

            $delQuery = "DELETE FROM competxprograma WHERE competencia_comp_id = :comp_id";
            $this->db->prepare($delQuery)->execute([':comp_id' => $compId]);

            if (!empty($programaIds)) {
                $insQuery = "INSERT INTO competxprograma (competencia_comp_id, programa_prog_id) VALUES (:comp_id, :prog_id)";
                $stmt = $this->db->prepare($insQuery);
                foreach ($programaIds as $progId) {
                    $stmt->execute([':comp_id' => $compId, ':prog_id' => $progId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function deleteAllByCompetencia($compId)
    {
        $query = "DELETE FROM competxprograma WHERE competencia_comp_id = :comp_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':comp_id' => $compId]);
    }
}
