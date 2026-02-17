<?php
require_once dirname(__DIR__) . '/Conexion.php';

class CoordinacionModel
{
    private $coord_id;
    private $coord_nombre;
    private $centro_formacion_cent_id;
    private $db;

    public function __construct($coord_id = null, $coord_nombre = null, $centro_formacion_cent_id = null)
    {
        $this->coord_id = $coord_id;
        $this->coord_nombre = $coord_nombre;
        $this->centro_formacion_cent_id = $centro_formacion_cent_id;
        $this->db = Conexion::getConnect();
    }

    // Getters
    public function getCoordId()
    {
        return $this->coord_id;
    }
    public function getCoordNombre()
    {
        return $this->coord_nombre;
    }
    public function getCentroFormacionCentId()
    {
        return $this->centro_formacion_cent_id;
    }

    // Setters
    public function setCoordId($coord_id)
    {
        $this->coord_id = $coord_id;
    }
    public function setCoordNombre($coord_nombre)
    {
        $this->coord_nombre = $coord_nombre;
    }
    public function setCentroFormacionCentId($cent_id)
    {
        $this->centro_formacion_cent_id = $cent_id;
    }

    public function create()
    {
        $query = "INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) 
                  VALUES (:coord_nombre, :cent_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':coord_nombre', $this->coord_nombre);
        $stmt->bindParam(':cent_id', $this->centro_formacion_cent_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function read()
    {
        $query = "SELECT c.*, cf.cent_nombre 
                  FROM coordinacion c 
                  INNER JOIN centro_formacion cf ON c.centro_formacion_cent_id = cf.cent_id 
                  WHERE c.coord_id = :coord_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':coord_id' => $this->coord_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $query = "SELECT c.*, cf.cent_nombre 
                  FROM coordinacion c 
                  INNER JOIN centro_formacion cf ON c.centro_formacion_cent_id = cf.cent_id 
                  ORDER BY c.coord_nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE coordinacion 
                  SET coord_nombre = :coord_nombre, centro_formacion_cent_id = :cent_id 
                  WHERE coord_id = :coord_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':coord_nombre', $this->coord_nombre);
        $stmt->bindParam(':cent_id', $this->centro_formacion_cent_id);
        $stmt->bindParam(':coord_id', $this->coord_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM coordinacion WHERE coord_id = :coord_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':coord_id', $this->coord_id);
        return $stmt->execute();
    }
}
