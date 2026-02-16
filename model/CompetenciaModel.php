<?php
require_once dirname(__DIR__) . '/Conexion.php';

class CompetenciaModel
{
    private $comp_id;
    private $comp_nombre_corto;
    private $comp_horas;
    private $comp_nombre_unidad_competencia;
    private $db;

    public function __construct($comp_id = null, $comp_nombre_corto = null, $comp_horas = null, $comp_nombre_unidad_competencia = null)
    {
        $this->setCompId($comp_id);
        $this->setCompNombreCorto($comp_nombre_corto);
        $this->setCompHoras($comp_horas);
        $this->setCompNombreUnidadCompetencia($comp_nombre_unidad_competencia);
        $this->db = Conexion::getConnect();
    }

    // Getters
    public function getCompId()
    {
        return $this->comp_id;
    }
    public function getCompNombreCorto()
    {
        return $this->comp_nombre_corto;
    }
    public function getCompHoras()
    {
        return $this->comp_horas;
    }
    public function getCompNombreUnidadCompetencia()
    {
        return $this->comp_nombre_unidad_competencia;
    }

    // Setters
    public function setCompId($comp_id)
    {
        $this->comp_id = $comp_id;
    }
    public function setCompNombreCorto($comp_nombre_corto)
    {
        $this->comp_nombre_corto = $comp_nombre_corto;
    }
    public function setCompHoras($comp_horas)
    {
        $this->comp_horas = $comp_horas;
    }
    public function setCompNombreUnidadCompetencia($comp_nombre_unidad_competencia)
    {
        $this->comp_nombre_unidad_competencia = $comp_nombre_unidad_competencia;
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO competencia (comp_nombre_corto, comp_horas, comp_nombre_unidad_competencia) 
                  VALUES (:comp_nombre_corto, :comp_horas, :comp_nombre_unidad_competencia)
                  RETURNING comp_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comp_nombre_corto', $this->comp_nombre_corto);
        $stmt->bindParam(':comp_horas', $this->comp_horas);
        $stmt->bindParam(':comp_nombre_unidad_competencia', $this->comp_nombre_unidad_competencia);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function read()
    {
        $sql = "SELECT * FROM competencia WHERE comp_id = :comp_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':comp_id' => $this->comp_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM competencia ORDER BY comp_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE competencia 
                  SET comp_nombre_corto = :comp_nombre_corto, 
                      comp_horas = :comp_horas, 
                      comp_nombre_unidad_competencia = :comp_nombre_unidad_competencia
                  WHERE comp_id = :comp_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comp_nombre_corto', $this->comp_nombre_corto);
        $stmt->bindParam(':comp_horas', $this->comp_horas);
        $stmt->bindParam(':comp_nombre_unidad_competencia', $this->comp_nombre_unidad_competencia);
        $stmt->bindParam(':comp_id', $this->comp_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM competencia WHERE comp_id = :comp_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comp_id', $this->comp_id);
        return $stmt->execute();
    }

    // Association with Programs (competxprograma)
    public function getProgramasByCompetencia()
    {
        $sql = "SELECT p.*, t.titpro_nombre 
                FROM programa p
                INNER JOIN competxprograma cp ON p.prog_id = cp.programa_prog_id
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                WHERE cp.competencia_comp_id = :comp_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':comp_id' => $this->comp_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignProgramas($programaIds)
    {
        // First delete existing associations
        $delQuery = "DELETE FROM competxprograma WHERE competencia_comp_id = :comp_id";
        $this->db->prepare($delQuery)->execute([':comp_id' => $this->comp_id]);

        if (empty($programaIds)) return true;

        // Insert new associations
        $insQuery = "INSERT INTO competxprograma (competencia_comp_id, programa_prog_id) VALUES (:comp_id, :prog_id)";
        $stmt = $this->db->prepare($insQuery);
        foreach ($programaIds as $progId) {
            $stmt->execute([':comp_id' => $this->comp_id, ':prog_id' => $progId]);
        }
        return true;
    }
}
