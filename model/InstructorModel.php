<?php
require_once dirname(__DIR__) . '/Conexion.php';
class InstructorModel
{
    private $inst_id;
    private $inst_nombres;
    private $inst_apellidos;
    private $inst_correo;
    private $inst_telefono;
    private $sede_id;
    private $db;

    public function __construct($inst_id = null, $inst_nombres = null, $inst_apellidos = null, $inst_correo = null, $inst_telefono = null, $sede_id = null)
    {
        $this->inst_id = $inst_id;
        $this->inst_nombres = $inst_nombres;
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
    public function getInstNombres()
    {
        return $this->inst_nombres;
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
    public function setInstNombres($inst_nombres)
    {
        $this->inst_nombres = $inst_nombres;
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
        try {
            $query = "INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) 
            VALUES (:inst_nombres, :inst_apellidos, :inst_correo, :inst_telefono, :sede_id)
            RETURNING inst_id";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':inst_nombres', $this->inst_nombres);
            $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
            $stmt->bindParam(':inst_correo', $this->inst_correo);

            // Set null if empty string for numbers to avoid PG errors
            $telefono = !empty($this->inst_telefono) ? $this->inst_telefono : null;
            $stmt->bindParam(':inst_telefono', $telefono);

            $sedeId = !empty($this->sede_id) ? $this->sede_id : null;
            $stmt->bindParam(':sede_id', $sedeId);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['inst_id'] ?? false;
        } catch (PDOException $e) {
            error_log("Error en InstructorModel::create: " . $e->getMessage());
            throw $e;
        }
    }
    public function read()
    {
        $sql = "SELECT i.*, c.cent_nombre 
                FROM instructor i 
                LEFT JOIN centro_formacion c ON i.centro_formacion_cent_id = c.cent_id 
                WHERE i.inst_id = :inst_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':inst_id' => $this->inst_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT i.*, c.cent_nombre 
                FROM instructor i 
                LEFT JOIN centro_formacion c ON i.centro_formacion_cent_id = c.cent_id 
                ORDER BY i.inst_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        try {
            $query = "UPDATE instructor 
                      SET inst_nombres = :inst_nombres, 
                          inst_apellidos = :inst_apellidos, 
                          inst_correo = :inst_correo, 
                          inst_telefono = :inst_telefono, 
                          centro_formacion_cent_id = :sede_id 
                      WHERE inst_id = :inst_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':inst_nombres', $this->inst_nombres);
            $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
            $stmt->bindParam(':inst_correo', $this->inst_correo);

            $telefono = !empty($this->inst_telefono) ? $this->inst_telefono : null;
            $stmt->bindParam(':inst_telefono', $telefono);

            $sedeId = !empty($this->sede_id) ? $this->sede_id : null;
            $stmt->bindParam(':sede_id', $sedeId);

            $stmt->bindParam(':inst_id', $this->inst_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en InstructorModel::update: " . $e->getMessage());
            throw $e;
        }
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
