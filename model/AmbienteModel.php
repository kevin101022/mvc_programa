<?php
require_once dirname(__DIR__) . '/Conexion.php';
class AmbienteModel
{
    private $amb_id;
    private $amb_nombre;
    private $sede_sede_id;

    private $db;

    public function __construct($amb_id, $amb_nombre, $sede_sede_id)
    {
        $this->setAmbId($amb_id);
        $this->setAmbnombre($amb_nombre);
        $this->setSedeSedeId($sede_sede_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getAmbId()
    {
        return $this->amb_id;
    }
    public function getAmbnombre()
    {
        return $this->amb_nombre;
    }
    public function getSedeSedeId()
    {
        return $this->sede_sede_id;
    }

    //setters 
    public function setAmbId($amb_id)
    {
        $this->amb_id = $amb_id;
    }
    public function setAmbnombre($amb_nombre)
    {
        $this->amb_nombre = $amb_nombre;
    }
    public function setSedeSedeId($sede_sede_id)
    {
        $this->sede_sede_id = $sede_sede_id;
    }
    //crud
    public function create()
    {
        try {
            // Primero intentamos sin el ID (asumiendo SERIAL)
            $query = "INSERT INTO ambiente (amb_nombre, sede_sede_id) VALUES (:amb_nombre, :sede)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':amb_nombre', $this->amb_nombre);
            $stmt->bindParam(':sede', $this->sede_sede_id);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Si falla por restricción not-null en amb_id, es que no es SERIAL
            if ($e->getCode() == '23502') {
                // Intentamos obtener el siguiente ID manualmente
                $maxId = $this->db->query("SELECT COALESCE(MAX(CAST(amb_id AS INTEGER)), 0) + 1 FROM ambiente")->fetchColumn();
                $query = "INSERT INTO ambiente (amb_id, amb_nombre, sede_sede_id) VALUES (:id, :amb_nombre, :sede)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $maxId);
                $stmt->bindParam(':amb_nombre', $this->amb_nombre);
                $stmt->bindParam(':sede', $this->sede_sede_id);
                $stmt->execute();
                return $maxId;
            }
            throw $e;
        }
    }
    public function read()
    {
        $sql = "SELECT a.*, s.sede_nombre 
                FROM ambiente a 
                INNER JOIN sede s ON a.sede_sede_id = s.sede_id 
                WHERE a.sede_sede_id = :sede";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede' => $this->sede_sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT a.*, s.sede_nombre 
                FROM ambiente a 
                INNER JOIN sede s ON a.sede_sede_id = s.sede_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT a.*, s.sede_nombre 
                FROM ambiente a 
                INNER JOIN sede s ON a.sede_sede_id = s.sede_id 
                WHERE a.amb_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE ambiente SET amb_nombre = :amb_nombre, sede_sede_id = :sede WHERE amb_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_nombre', $this->amb_nombre);
        $stmt->bindParam(':sede', $this->sede_sede_id);
        $stmt->bindParam(':id', $this->amb_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM ambiente WHERE amb_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->amb_id);
        $stmt->execute();
        return $stmt;
    }
}
