<?php
require_once dirname(__DIR__) . '/Conexion.php';
class DetalleAsignacionModel
{
    private $asignacion_asig_id;
    private $detasig_hora_ini;
    private $detasig_hora_fin;
    private $detasig_id;
    private $db;

    public function __construct($asignacion_asig_id = null, $detasig_hora_ini = null, $detasig_hora_fin = null, $detasig_id = null)
    {
        $this->asignacion_asig_id = $asignacion_asig_id;
        $this->detasig_hora_ini = $detasig_hora_ini;
        $this->detasig_hora_fin = $detasig_hora_fin;
        $this->detasig_id = $detasig_id;
        $this->db = Conexion::getConnect();
    }

    public function create()
    {
        $query = "INSERT INTO DETALLExASIGNACION (ASIGNACION_ASIG_ID, detasig_hora_ini, detasig_hora_fin) 
                  VALUES (:asig_id, :hora_ini, :hora_fin)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asig_id', $this->asignacion_asig_id);
        $stmt->bindParam(':hora_ini', $this->detasig_hora_ini);
        $stmt->bindParam(':hora_fin', $this->detasig_hora_fin);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function readAllByAsignacion($asig_id)
    {
        $sql = "SELECT * FROM DETALLExASIGNACION WHERE ASIGNACION_ASIG_ID = :asig_id ORDER BY detasig_hora_ini ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':asig_id' => $asig_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... otros métodos actualizados con el nombre de tabla DETALLExASIGNACION
    public function update()
    {
        $query = "UPDATE DETALLExASIGNACION SET ASIGNACION_ASIG_ID = :asig_id, detasig_hora_ini = :hora_ini, detasig_hora_fin = :hora_fin WHERE detasig_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asig_id', $this->asignacion_asig_id);
        $stmt->bindParam(':hora_ini', $this->detasig_hora_ini);
        $stmt->bindParam(':hora_fin', $this->detasig_hora_fin);
        $stmt->bindParam(':id', $this->detasig_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM DETALLExASIGNACION WHERE detasig_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->detasig_id);
        return $stmt->execute();
    }
}
