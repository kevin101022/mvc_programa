<?php
require_once dirname(__DIR__) . '/Conexion.php';
class ProgramaModel
{
    private $prog_id;
    private $prog_codigo;
    private $prog_denominacion;
    private $tit_programa_titpro_id;
    private $prog_tipo;
    private $sede_sede_id;
    private $db;

    public function __construct($prog_id = null, $prog_codigo = null, $prog_denominacion = null, $tit_programa_titpro_id = null, $prog_tipo = null, $sede_sede_id = null)
    {
        $this->setProgId($prog_id);
        $this->setProgCodigo($prog_codigo);
        $this->setProgDenominacion($prog_denominacion);
        $this->setTitProgramaTitproId($tit_programa_titpro_id);
        $this->setProgTipo($prog_tipo);
        $this->setSedeSedeId($sede_sede_id);
        $this->db = Conexion::getConnect();
    }

    // Getters
    public function getProgId()
    {
        return $this->prog_id;
    }
    public function getProgCodigo()
    {
        return $this->prog_codigo;
    }
    public function getProgDenominacion()
    {
        return $this->prog_denominacion;
    }
    public function getTitProgramaTitproId()
    {
        return $this->tit_programa_titpro_id;
    }
    public function getProgTipo()
    {
        return $this->prog_tipo;
    }
    public function getSedeSedeId()
    {
        return $this->sede_sede_id;
    }

    // Setters
    public function setProgId($prog_id)
    {
        $this->prog_id = $prog_id;
    }
    public function setProgCodigo($prog_codigo)
    {
        $this->prog_codigo = $prog_codigo;
    }
    public function setProgDenominacion($prog_denominacion)
    {
        $this->prog_denominacion = $prog_denominacion;
    }
    public function setTitProgramaTitproId($tit_programa_titpro_id)
    {
        $this->tit_programa_titpro_id = $tit_programa_titpro_id;
    }
    public function setProgTipo($prog_tipo)
    {
        $this->prog_tipo = $prog_tipo;
    }
    public function setSedeSedeId($sede_sede_id)
    {
        $this->sede_sede_id = $sede_sede_id;
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO programa (prog_codigo, prog_denominacion, tit_programa_titpro_id, prog_tipo, sede_sede_id) 
                  VALUES (:prog_codigo, :prog_denominacion, :tit_programa_titpro_id, :prog_tipo, :sede_sede_id)
                  RETURNING prog_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':prog_codigo', $this->prog_codigo);
        $stmt->bindParam(':prog_denominacion', $this->prog_denominacion);
        $stmt->bindParam(':tit_programa_titpro_id', $this->tit_programa_titpro_id);
        $stmt->bindParam(':prog_tipo', $this->prog_tipo);
        $stmt->bindParam(':sede_sede_id', $this->sede_sede_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function read()
    {
        $sql = "SELECT p.*, t.titpro_nombre, s.sede_nombre 
                FROM programa p
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                LEFT JOIN sede s ON p.sede_sede_id = s.sede_id
                WHERE p.prog_id = :prog_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':prog_id' => $this->prog_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT p.*, t.titpro_nombre, s.sede_nombre 
                FROM programa p
                INNER JOIN titulo_programa t ON p.tit_programa_titpro_id = t.titpro_id
                LEFT JOIN sede s ON p.sede_sede_id = s.sede_id
                ORDER BY p.prog_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE programa 
                  SET prog_codigo = :prog_codigo, 
                      prog_denominacion = :prog_denominacion, 
                      tit_programa_titpro_id = :tit_programa_titpro_id, 
                      prog_tipo = :prog_tipo,
                      sede_sede_id = :sede_sede_id
                  WHERE prog_id = :prog_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':prog_codigo', $this->prog_codigo);
        $stmt->bindParam(':prog_denominacion', $this->prog_denominacion);
        $stmt->bindParam(':tit_programa_titpro_id', $this->tit_programa_titpro_id);
        $stmt->bindParam(':prog_tipo', $this->prog_tipo);
        $stmt->bindParam(':sede_sede_id', $this->sede_sede_id);
        $stmt->bindParam(':prog_id', $this->prog_id);
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM programa WHERE prog_id = :prog_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':prog_id', $this->prog_id);
        return $stmt->execute();
    }
}
