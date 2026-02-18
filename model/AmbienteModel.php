<?php
require_once dirname(__DIR__) . '/Conexion.php';
require_once __DIR__ . '/SchemaResilienceTrait.php';

class AmbienteModel
{
    use SchemaResilienceTrait;

    private $amb_id;
    private $amb_nombre;
    private $sede_sede_id;
    private $db;

    public function __construct($amb_id = null, $amb_nombre = null, $sede_sede_id = null)
    {
        $this->amb_id = $amb_id;
        $this->amb_nombre = $amb_nombre;
        $this->sede_sede_id = $sede_sede_id;
        $this->db = Conexion::getConnect();
    }

    // Getters 
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

    // Setters 
    public function setAmbId($id)
    {
        $this->amb_id = $id;
    }
    public function setAmbnombre($name)
    {
        $this->amb_nombre = $name;
    }
    public function setSedeSedeId($id)
    {
        $this->sede_sede_id = $id;
    }

    // CRUD
    public function getNextId()
    {
        $query = "SELECT COALESCE(MAX(CASE WHEN amb_id ~ '^[0-9]+$' THEN CAST(amb_id AS INTEGER) ELSE 0 END), 0) + 1 FROM ambiente";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return (string)$stmt->fetchColumn();
    }

    public function create()
    {
        $retryLogic = function () {
            if (!$this->amb_id) {
                $this->amb_id = $this->getNextId();
            }
            $query = "INSERT INTO ambiente (amb_id, amb_nombre, sede_sede_id) VALUES (:id, :amb_nombre, :sede)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->amb_id);
            $stmt->bindParam(':amb_nombre', $this->amb_nombre);
            $stmt->bindParam(':sede', $this->sede_sede_id);
            return $stmt->execute();
        };

        try {
            return $retryLogic();
        } catch (PDOException $e) {
            return $this->handleTruncation($e, 'ambiente', [
                'amb_nombre' => $this->amb_nombre
            ], $retryLogic);
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
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM ambiente WHERE amb_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->amb_id);
        return $stmt->execute();
    }
}
