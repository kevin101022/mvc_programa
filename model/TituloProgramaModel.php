<?php
require_once dirname(__DIR__) . '/Conexion.php';
class TituloProgramaModel
{
    private $titpro_id;
    private $titpro_nombre;
    private $db;

    public function __construct($titpro_id = null, $titpro_nombre = null)
    {
        $this->setTitproId($titpro_id);
        $this->setTitproNombre($titpro_nombre);
        $this->db = Conexion::getConnect();
    }

    // Getters
    public function getTitproId()
    {
        return $this->titpro_id;
    }
    public function getTitproNombre()
    {
        return $this->titpro_nombre;
    }

    // Setters
    public function setTitproId($titpro_id)
    {
        $this->titpro_id = $titpro_id;
    }
    public function setTitproNombre($titpro_nombre)
    {
        $this->titpro_nombre = $titpro_nombre;
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO titulo_programa (titpro_nombre) VALUES (:titpro_nombre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titpro_nombre', $this->titpro_nombre);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function read()
    {
        $sql = "SELECT * FROM titulo_programa WHERE titpro_id = :titpro_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':titpro_id' => $this->titpro_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM titulo_programa ORDER BY titpro_nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE titulo_programa SET titpro_nombre = :titpro_nombre WHERE titpro_id = :titpro_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titpro_nombre', $this->titpro_nombre);
        $stmt->bindParam(':titpro_id', $this->titpro_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM titulo_programa WHERE titpro_id = :titpro_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titpro_id', $this->titpro_id);
        return $stmt->execute();
    }
}
