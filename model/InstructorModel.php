<?php
require_once dirname(__DIR__) . '/Conexion.php';
class InstructorModel
{
    private $inst_id;
    private $inst_nombre;
    private $inst_apellidos;
    private $inst_correo;
    private $inst_telefono;
    private $sede_id;
    private $db;

    public function __construct($inst_id = null, $inst_nombre = null, $inst_apellidos = null, $inst_correo = null, $inst_telefono = null, $sede_id = null)
    {
        $this->inst_id = $inst_id;
        $this->inst_nombre = $inst_nombre;
        $this->inst_apellidos = $inst_apellidos;
        $this->inst_correo = $inst_correo;
        $this->inst_telefono = $inst_telefono;
        $this->sede_id = $sede_id;
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getInstId()
    {
        return $this->inst_id;
    }
    public function getInstNombre()
    {
        return $this->inst_nombre;
    }
    public function getInstApellidos()
    {
        return $this->inst_apellidos;
    }
    public function getInstCorreo()
    {
        return $this->inst_correo;
    }
    public function getInstTelefono()
    {
        return $this->inst_telefono;
    }

    public function getSedeId()
    {
        return $this->sede_id;
    }

    //setters 
    public function setInstId($inst_id)
    {
        $this->inst_id = $inst_id;
    }
    public function setInstNombre($inst_nombre)
    {
        $this->inst_nombre = $inst_nombre;
    }
    public function setInstApellidos($inst_apellidos)
    {
        $this->inst_apellidos = $inst_apellidos;
    }
    public function setInstCorreo($inst_correo)
    {
        $this->inst_correo = $inst_correo;
    }
    public function setInstTelefono($inst_telefono)
    {
        $this->inst_telefono = $inst_telefono;
    }
    public function setSedeId($sede_id)
    {
        $this->sede_id = $sede_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) 
        VALUES (:inst_nombres, :inst_apellidos, :inst_correo, :inst_telefono, :sede_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombres', $this->inst_nombre);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
        $stmt->bindParam(':sede_id', $this->sede_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT i.*, s.sede_nombre 
                FROM instructor i 
                LEFT JOIN sede s ON i.centro_formacion_cent_id = s.sede_id 
                WHERE i.inst_id = :inst_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':inst_id' => $this->inst_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT i.*, s.sede_nombre 
                FROM instructor i 
                LEFT JOIN sede s ON i.centro_formacion_cent_id = s.sede_id 
                ORDER BY i.inst_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE instructor SET inst_nombres = :inst_nombres, inst_apellidos = :inst_apellidos, inst_correo = :inst_correo, inst_telefono = :inst_telefono, centro_formacion_cent_id = :sede_id WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombres', $this->inst_nombre);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
        $stmt->bindParam(':sede_id', $this->sede_id);
        $stmt->bindParam(':inst_id', $this->inst_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM instructor WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_id', $this->inst_id);
        $stmt->execute();
        return $stmt;
    }
}
