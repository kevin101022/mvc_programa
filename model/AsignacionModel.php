<?php
require_once dirname(__DIR__) . '/Conexion.php';
class AsignacionModel
{
    private $asig_id;
    private $instructor_inst_id;
    private $asig_fecha_ini;
    private $asig_fecha_fin;
    private $ficha_fich_id;
    private $ambiente_amb_id;
    private $competencia_comp_id;
    private $db;

    public function __construct($asig_id, $instructor_inst_id, $asig_fecha_ini, $asig_fecha_fin, $ficha_fich_id, $ambiente_amb_id, $competencia_comp_id)
    {
        $this->setAsigId($asig_id);
        $this->setInstructorInstId($instructor_inst_id);
        $this->setAsigFechaIni($asig_fecha_ini);
        $this->setAsigFechaFin($asig_fecha_fin);
        $this->setFichaFichId($ficha_fich_id);
        $this->setAmbienteAmbId($ambiente_amb_id);
        $this->setCompetenciaCompId($competencia_comp_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getAsigId()
    {
        return $this->asig_id;
    }
    public function getInstructorInstId()
    {
        return $this->instructor_inst_id;
    }
    public function getAsigFechaIni()
    {
        return $this->asig_fecha_ini;
    }
    public function getAsigFechaFin()
    {
        return $this->asig_fecha_fin;
    }
    public function getFichaFichId()
    {
        return $this->ficha_fich_id;
    }
    public function getAmbienteAmbId()
    {
        return $this->ambiente_amb_id;
    }
    public function getCompetenciaCompId()
    {
        return $this->competencia_comp_id;
    }

    //setters 
    public function setAsigId($asig_id)
    {
        $this->asig_id = $asig_id;
    }
    public function setInstructorInstId($instructor_inst_id)
    {
        $this->instructor_inst_id = $instructor_inst_id;
    }
    public function setAsigFechaIni($asig_fecha_ini)
    {
        $this->asig_fecha_ini = $asig_fecha_ini;
    }
    public function setAsigFechaFin($asig_fecha_fin)
    {
        $this->asig_fecha_fin = $asig_fecha_fin;
    }
    public function setFichaFichId($ficha_fich_id)
    {
        $this->ficha_fich_id = $ficha_fich_id;
    }
    public function setAmbienteAmbId($ambiente_amb_id)
    {
        $this->ambiente_amb_id = $ambiente_amb_id;
    }
    public function setCompetenciaCompId($competencia_comp_id)
    {
        $this->competencia_comp_id = $competencia_comp_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO asignacion (instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id) 
                  VALUES (:instructor_id, :fecha_ini, :fecha_fin, :ficha_id, :ambiente_id, :competencia_id) RETURNING asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':instructor_id', $this->instructor_inst_id);
        $stmt->bindParam(':fecha_ini', $this->asig_fecha_ini);
        $stmt->bindParam(':fecha_fin', $this->asig_fecha_fin);
        $stmt->bindParam(':ficha_id', $this->ficha_fich_id);
        $stmt->bindParam(':ambiente_id', $this->ambiente_amb_id);
        $stmt->bindParam(':competencia_id', $this->competencia_comp_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['asig_id'] ?? false;
    }
    public function read()
    {
        $sql = "SELECT a.*, i.inst_nombres, i.inst_apellidos, f.fich_id, am.amb_nombre, c.comp_nombre_corto 
                FROM asignacion a
                INNER JOIN instructor i ON a.instructor_inst_id = i.inst_id
                INNER JOIN ficha f ON a.ficha_fich_id = f.fich_id
                INNER JOIN ambiente am ON a.ambiente_amb_id = am.amb_id
                INNER JOIN competencia c ON a.competencia_comp_id = c.comp_id
                WHERE a.asig_id = :asig_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':asig_id' => $this->asig_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT a.*, i.inst_nombres, i.inst_apellidos, f.fich_id, am.amb_nombre, c.comp_nombre_corto 
                FROM asignacion a
                INNER JOIN instructor i ON a.instructor_inst_id = i.inst_id
                INNER JOIN ficha f ON a.ficha_fich_id = f.fich_id
                INNER JOIN ambiente am ON a.ambiente_amb_id = am.amb_id
                INNER JOIN competencia c ON a.competencia_comp_id = c.comp_id
                ORDER BY a.asig_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE asignacion 
                  SET instructor_inst_id = :instructor_id, 
                      asig_fecha_ini = :fecha_ini, 
                      asig_fecha_fin = :fecha_fin, 
                      ficha_fich_id = :ficha_id, 
                      ambiente_amb_id = :ambiente_id, 
                      competencia_comp_id = :competencia_id 
                  WHERE asig_id = :asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':instructor_id', $this->instructor_inst_id);
        $stmt->bindParam(':fecha_ini', $this->asig_fecha_ini);
        $stmt->bindParam(':fecha_fin', $this->asig_fecha_fin);
        $stmt->bindParam(':ficha_id', $this->ficha_fich_id);
        $stmt->bindParam(':ambiente_id', $this->ambiente_amb_id);
        $stmt->bindParam(':competencia_id', $this->competencia_comp_id);
        $stmt->bindParam(':asig_id', $this->asig_id);
        return $stmt->execute();
    }
    public function delete()
    {
        $query = "DELETE FROM asignacion WHERE asig_id = :asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asig_id', $this->asig_id);
        return $stmt->execute();
    }
}
