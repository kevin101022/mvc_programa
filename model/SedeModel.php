<?php
require_once dirname(__DIR__) . '/Conexion.php';
require_once __DIR__ . '/SchemaResilienceTrait.php';

class SedeModel
{
    use SchemaResilienceTrait;

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

    // Getters
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

    // Setters
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

    // CRUD helpers
    public function getNextId()
    {
        $query = "SELECT COALESCE(MAX(sede_id), 0) + 1 FROM sede";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function create()
    {
        $retryLogic = function () {
            if (!$this->sede_id) {
                $this->sede_id = $this->getNextId();
            }
            $query = "INSERT INTO sede (sede_id, sede_nombre, foto) 
            VALUES (:sede_id, :sede_nombre, :foto)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':sede_id', $this->sede_id);
            $stmt->bindParam(':sede_nombre', $this->sede_nombre);
            $stmt->bindParam(':foto', $this->sede_foto);
            $stmt->execute();
            return $this->sede_id;
        };

        try {
            return $retryLogic();
        } catch (PDOException $e) {
            return $this->handleTruncation($e, 'sede', [
                'sede_nombre' => $this->sede_nombre,
                'foto' => $this->sede_foto
            ], $retryLogic);
        }
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

    public function getFichasBySede()
    {
        $sql = "SELECT DISTINCT ON (f.fich_id) 
                       f.*, 
                       p.prog_denominacion, 
                       tp.titpro_nombre,
                       i.inst_nombres, 
                       i.inst_apellidos, 
                       c.coord_descripcion as coord_nombre
                FROM ficha f
                INNER JOIN programa p ON f.programa_prog_id = p.prog_codigo
                INNER JOIN titulo_programa tp ON p.tit_programa_titpro_id = tp.titpro_id
                INNER JOIN instructor i ON f.instructor_inst_id_lider = i.inst_id
                LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
                INNER JOIN asignacion a ON f.fich_id = a.ficha_fich_id
                INNER JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
                WHERE amb.sede_sede_id = :sede_id
                ORDER BY f.fich_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede_id' => $this->sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
