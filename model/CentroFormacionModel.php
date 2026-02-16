<?php
require_once dirname(__DIR__) . '/Conexion.php';

class CentroFormacionModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::getConnect();
    }

    public function getAll()
    {
        $query = "SELECT * FROM centro_formacion ORDER BY cent_nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
