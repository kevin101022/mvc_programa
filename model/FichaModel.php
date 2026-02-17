<?php
require_once dirname(__DIR__) . '/Conexion.php';
class FichaModel
{
    private $fich_id;
    private $programa_prog_id;
    private $instructor_inst_id;
    private $fich_jornada;
    private $coordinacion_id;
    private $db;

    public function __construct($fich_id, $programa_prog_id, $instructor_inst_id, $fich_jornada, $coordinacion_id = null)
    {
        $this->setFichId($fich_id);
        $this->setProgramaProgId($programa_prog_id);
        $this->setInstructorInstId($instructor_inst_id);
        $this->setFichJornada($fich_jornada);
        $this->setCoordinacionId($coordinacion_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getFichId()
    {
        return $this->fich_id;
    }
    public function getProgramaProgId()
    {
        return $this->programa_prog_id;
    }
    public function getInstructorInstId()
    {
        return $this->instructor_inst_id;
    }
    public function getFichJornada()
    {
        return $this->fich_jornada;
    }

    //setters 
    public function setFichId($fich_id)
    {
        $this->fich_id = $fich_id;
    }
    public function setProgramaProgId($programa_prog_id)
    {
        $this->programa_prog_id = $programa_prog_id;
    }
    public function setInstructorInstId($instructor_inst_id)
    {
        $this->instructor_inst_id = $instructor_inst_id;
    }
    public function setFichJornada($fich_jornada)
    {
        $this->fich_jornada = $fich_jornada;
    }
    public function setCoordinacionId($coordinacion_id)
    {
        $this->coordinacion_id = $coordinacion_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO ficha (fich_id, programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) 
        VALUES (:fich_id, :programa_prog_id, :instructor_inst_id, :fich_jornada, :coordinacion_id) RETURNING fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fich_id', $this->fich_id);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->bindParam(':coordinacion_id', $this->coordinacion_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fich_id'] ?? false;
    }
    public function read()
    {
        $sql = "SELECT f.*, t.titpro_nombre, i.inst_nombres, i.inst_apellidos, c.coord_nombre 
                FROM ficha f
                INNER JOIN programa p ON f.programa_prog_id = p.prog_id
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                INNER JOIN instructor i ON f.instructor_inst_id = i.inst_id
                LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
                WHERE f.fich_id = :fich_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':fich_id' => $this->fich_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT f.*, t.titpro_nombre, i.inst_nombres, i.inst_apellidos, c.coord_nombre 
                FROM ficha f
                INNER JOIN programa p ON f.programa_prog_id = p.prog_id
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                INNER JOIN instructor i ON f.instructor_inst_id = i.inst_id
                LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
                ORDER BY f.fich_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE ficha SET programa_prog_id = :programa_prog_id, instructor_inst_id = :instructor_inst_id, fich_jornada = :fich_jornada, coordinacion_coord_id = :coordinacion_id WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->bindParam(':coordinacion_id', $this->coordinacion_id);
        $stmt->bindParam(':fich_id', $this->fich_id);
        return $stmt->execute();
    }
    public function delete()
    {
        $query = "DELETE FROM ficha WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fich_id', $this->fich_id);
        $stmt->execute();
        return $stmt;
    }
}
