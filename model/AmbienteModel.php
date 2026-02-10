<?php

class AmbienteModel
{
    private $id_ambiente;
    private $amb_nombre;
    private $Sede_sede_id;

    public function __construct($id_ambiente, $amb_nombre, $Sede_sede_id) 
    {
        $this->setIdAmbiente($id_ambiente);
        $this->setAmbnombre($amb_nombre);
        $this->setSedeSedeId($Sede_sede_id);
    }

//getters 

public function getIdAmbiente(){
    return $this->id_ambiente;
}
public function getAmbnombre(){
    return $this->amb_nombre;
}
public function getSedeSedeId(){
    return $this->Sede_sede_id;
}

//setters 
public function setIdAmbiente($id_ambiente){
    $this->id_ambiente=$id_ambiente;
}
public function setAmbnombre($amb_nombre){
    $this->amb_nombre=$amb_nombre;
}
public function setSedeSedeId($Sede_sede_id){
    $this->Sede_sede_id=$Sede_sede_id;
}






}



