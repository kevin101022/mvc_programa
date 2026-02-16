<?php
require_once dirname(__DIR__) . '/Conexion.php';
class SedeModel
{
    private $sede_id;
    private $sede_nombre;
    private $sede_foto;
    private $db;

    public function __construct($sede_id = null, $sede_nombre = null, $sede_foto = null)
    {
        $this->setSedeId($sede_id);
        $this->setSedeNombre($sede_nombre);
        $this->setSedeFoto($sede_foto);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getSedeId()
    {
        return $this->sede_id;
    }
    public function getSedeNombre()
    {
        return $this->sede_nombre;
    }
    public function getSedeFoto()
    {
        return $this->sede_foto;
    }

    //setters 
    public function setSedeId($sede_id)
    {
        $this->sede_id = $sede_id;
    }
    public function setSedeNombre($sede_nombre)
    {
        $this->sede_nombre = $sede_nombre;
    }
    public function setSedeFoto($sede_foto)
    {
        $this->sede_foto = $sede_foto;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO sede (sede_nombre, foto) 
        VALUES (:sede_nombre, :foto)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sede_nombre', $this->sede_nombre);
        $stmt->bindParam(':foto', $this->sede_foto);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT sede_id, sede_nombre, foto AS sede_foto FROM sede WHERE sede_id = :sede_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede_id' => $this->sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT sede_id, sede_nombre, foto AS sede_foto FROM sede";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE sede SET sede_nombre = :sede_nombre, foto = :foto WHERE sede_id = :sede_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sede_nombre', $this->sede_nombre);
        $stmt->bindParam(':foto', $this->sede_foto);
        $stmt->bindParam(':sede_id', $this->sede_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM sede WHERE sede_id = :sede_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sede_id', $this->sede_id);
        $stmt->execute();
        return $stmt;
    }

    public function getProgramasBySede()
    {
        $sql = "SELECT p.*, t.titpro_nombre 
                FROM programa p
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                WHERE p.sede_sede_id = :sede_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede_id' => $this->sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
