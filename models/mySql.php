<?php

class MySQL
{

    private $ipServidor = "localhost"; // inicializamos la ip del servidor de nuestro motor de base de datos
    private $usuarioBase = "root"; // inicializamos el usuario base que tenemos registrado en nuestro motor de base de datos
    private $contrasena = ""; // inicializamos la contraseña que tengamos en nuestro motor de base de datos
    private $nombreBaseDatos = "cafeelbuensabor"; // inicializamos el nombre de la base de datos

    private $conexion; // inicializamos la variable para inicializar la conexion

    // creamos la funcion para conectar a la base de datos
    public function conectar()
    {
        // le damos el valor a la variable que inicializamos para poder hacer la conexion con la base de datos
        $dns = "mysql:host=$this->ipServidor;dbname=$this->nombreBaseDatos;charset=utf8mb4";

        try{
            $this->conexion = new PDO($dns,$this->usuarioBase,$this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }

    }

    // creamos la funcion para desconectar la base de datos
    public function desconectar()
    {
        // validamos que haya una conexion
        if($this->conexion)
        {
            // cerramos la conexion
            $this->conexion = null;
        }
    }
    
    public function obtenerConexion()
    {
        return $this->conexion;
    }

}

?>