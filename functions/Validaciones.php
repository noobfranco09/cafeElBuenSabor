<?php

class Validaciones{
    

    private array $datos;

    public function __construct($datos){
        $this->datos=$datos;

    }


    public function validarDatos(){
        require_once '../../models/mySql.php';

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

       
        if($resultado["contraseña"]!=$contraseña){
            $errores["contraseñaIncorrecta"]="La contraseña es incorrecta";
            return $errores;

        }
        
        $mysql->desconectar();
        return $errores;
        
        
    }

    public function validarProducto(){

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombre"])) && empty(trim($this->datos["precio"])) && empty(trim($this->datos["stock"])) && empty(trim($this->datos["categoria"]))
        && empty(trim($this->datos["estado"])) && empty(trim($this->datos["descripcion"])) )
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombre = $this->datos["nombre"];
        $precio = $this->datos["precio"];
        $stock = $this->datos["stock"];
        $categoria = $this->datos["categoria"];
        $estado = $this->datos["estado"];
        $descripcion = $this->datos["descripcion"];

        // Validar nombre (solo letras, espacios y acentos, longitud entre 2 y 100)
        if (!preg_match("/^[\p{L}\s]{2,100}$/u",$nombre)) {
            $errores["nombreInvalido"] = "El nombre no es válido.";
            return $errores;
        }

        // Validar precio (número decimal positivo con hasta 2 decimales)
        if (!preg_match("/^\d+(\.\d{1,2})?$/", $precio)) {
            $errores["precioInvalido"] = "El precio no es válido.";
            return $errores;
        }

        // Validar stock (solo números enteros positivos)
        if (!preg_match("/^\d+$/", $stock)) {
            $errores["stockInvalido"] = "El stock debe ser un número entero positivo.";
            return $errores;
        }

        // Validar categoría (ID numérico entero positivo - llave foránea)
        if (!preg_match("/^\d+$/", $categoria)) {
            $errores["categoriaInvalida"] = "La categoría no es válida.";
            return $errores;
        }

        // Validar estado (por ejemplo, solo "activo" o "inactivo")
        if (!preg_match("/^(activo|inactivo)$/i", $estado)) {
            $errores["estadoInvalido"] = "El estado debe ser 'activo' o 'inactivo'.";
            return $errores;
        }

        // Validar descripción (texto libre, longitud opcionalmente limitada)
        if (!preg_match("/^.{0,500}$/s", $descripcion)) {
            $errores["descripcionInvalida"] = "La descripción no puede superar los 500 caracteres.";
            return $errores;
        }

    }


}

?>