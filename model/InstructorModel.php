<?php
require_once dirname(__DIR__) . '/Conexion.php';
require_once __DIR__ . '/SchemaResilienceTrait.php';

class InstructorModel
{
    use SchemaResilienceTrait;

    private $inst_id;
    private $inst_nombres;
    private $inst_apellidos;
    private $inst_correo;
    private $inst_telefono;
    private $cent_id;
    private $inst_password;
    private $db;

    public function __construct($inst_id = null, $inst_nombres = null, $inst_apellidos = null, $inst_correo = null, $inst_telefono = null, $cent_id = null, $inst_password = null)
    {
        $this->inst_id = $inst_id;
        $this->inst_nombres = $inst_nombres;
        $this->inst_apellidos = $inst_apellidos;
        $this->inst_correo = $inst_correo;
        $this->inst_telefono = $inst_telefono;
        $this->inst_password = $inst_password;
        $this->cent_id = $cent_id;
        $this->db = Conexion::getConnect();
    }

    // Getters
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
    public function getInstPassword()
    {
        return $this->inst_password;
    }
    public function getCentId()
    {
        return $this->cent_id;
    }

    // Setters
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
    public function setInstPassword($inst_password)
    {
        $this->inst_password = $inst_password;
    }
    public function setCentId($cent_id)
    {
        $this->cent_id = $cent_id;
    }

    // CRUD
    public function getNextId()
    {
        $query = "SELECT COALESCE(MAX(inst_id), 0) + 1 FROM instructor";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function create()
    {
        $retryLogic = function () {
            if (!$this->inst_id) {
                $this->inst_id = $this->getNextId();
            }
            $query = "INSERT INTO instructor (inst_id, inst_nombres, inst_apellidos, inst_correo, inst_telefono, inst_password, centro_formacion_cent_id) 
            VALUES (:inst_id, :inst_nombres, :inst_apellidos, :inst_correo, :inst_telefono, :inst_password, :cent_id)";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':inst_id', $this->inst_id);
            $stmt->bindParam(':inst_nombres', $this->inst_nombres);
            $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
            $stmt->bindParam(':inst_correo', $this->inst_correo);
            $stmt->bindParam(':inst_password', $this->inst_password);

            $telefono = !empty($this->inst_telefono) ? $this->inst_telefono : null;
            $stmt->bindParam(':inst_telefono', $telefono);

            $centId = !empty($this->cent_id) ? $this->cent_id : null;
            $stmt->bindParam(':cent_id', $centId);

            $stmt->execute();
            return $this->inst_id;
        };

        try {
            return $retryLogic();
        } catch (PDOException $e) {
            return $this->handleTruncation($e, 'instructor', [
                'inst_nombres' => $this->inst_nombres,
                'inst_apellidos' => $this->inst_apellidos,
                'inst_correo' => $this->inst_correo,
                'inst_password' => $this->inst_password
            ], $retryLogic);
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
                          inst_password = :inst_password,
                          centro_formacion_cent_id = :cent_id 
                      WHERE inst_id = :inst_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':inst_nombres', $this->inst_nombres);
            $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
            $stmt->bindParam(':inst_correo', $this->inst_correo);
            $stmt->bindParam(':inst_password', $this->inst_password);

            $telefono = !empty($this->inst_telefono) ? $this->inst_telefono : null;
            $stmt->bindParam(':inst_telefono', $telefono);

            $centId = !empty($this->cent_id) ? $this->cent_id : null;
            $stmt->bindParam(':cent_id', $centId);

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
