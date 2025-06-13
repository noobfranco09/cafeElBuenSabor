<?php

class Validaciones{
    

    private array $datos;

    public function __construct($datos){
        $this->datos=$datos;

    }


    public function validarDatos(){
        include 'mySql.php';

        $mysql = new MySQL();

        
        $errores = [];
        if(empty(trim($this->datos["correo"]??""))||
        empty(trim($this->datos["contraseña"]??""))){
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }


        $correo = $this->datos["correo"];
        $contraseña=$this->datos["contraseña"];


        if(!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$correo) || !filter_var($correo,FILTER_VALIDATE_EMAIL)){
             $errores['errorCorreo']= 'El correo ingresado es invalido';

             return $errores;
        }

        $mysql->conectar();



        $consulta = "SELECT * FROM  usuario WHERE correo = :correo";

        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(':correo',$correo,PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $cantidadFilas = $stmt->rowCount();


        if($cantidadFilas==0){
            $errores["correoNoExiste"]="Este correo no existe";
            return $errores;
        }

        if($resultado["contrseña"]!=$contraseña){
            $errores["contraseñaIncorrecta"]="La contraseña es incorrecta";
            return $errores;
        }
        //Para verfiicar roles pero despues
        // if($resultado["idRoll"]!=1){

        //     $errores["noAdmin"]= "";
        // }

        
        
    }



}
?>