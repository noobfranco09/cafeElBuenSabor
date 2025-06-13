<?php

class Validaciones{
    

    private array $datos;

    public function __construct($datos){
        $this->datos=$datos;

    }


    public function validarDatos(){
        $errores = [];
        if(empty(trim($this->datos["correo"]??""))||
        empty(trim($this->datos["contraseña"]??""))){
            return $errores["datosVacio"]="Enviaste datos vacios";
        }
    }



}
?>