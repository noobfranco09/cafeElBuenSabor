<?php

class MySQL
{

    private $ipServidor = "localhost"; // inicializamos la ip del servidor de nuestro motor de base de datos
    private $usuarioBase = "root"; // inicializamos el usuario base que tenemos registrado en nuestro motor de base de datos
    private $contrasena = ""; // inicializamos la contraseña que tengamos en nuestro motor de base de datos
    private $nombreBaseDatos = ""; // inicializamos el nombre de la base de datos

    private $conexion; // inicializamos la variable para inicializar la conexion

    // creamos la funcion para conectar a la base de datos
    public function conectar()
    {
        // le damos el valor a la variable que inicializamos para poder hacer la conexion con la base de datos
        $this->conexion = mysqli_connect($this->ipServidor,$this->usuarioBase,$this->contrasena,$this->nombreBaseDatos);

        // verificamos que la conexion funcione sin ningun error
        if(!$this->conexion)
        {
            die("Error al conectar con la base de datos: ".mysqli_connect_error());
        }

        // le aplicamos la configuracion utf8 para evitar los signos raros
        mysqli_set_charset($this->conexion,"utf8");

    }

    // creamos la funcion para desconectar la base de datos
    public function desconectar()
    {
        // validamos que haya una conexion
        if($this->conexion)
        {
            // cerramos la conexion
            mysqli_close($this->conexion);
        }
    }


    // creamos la funcion para efectuar la consulta sql
    public function ejecutarConsulta($consulta)
    {
        // verificamos que la consulta sea utf8 para poder ejecutar la consulta eliminando asi los caracteres raros
        mysqli_query($this->conexion,"SET NAMES 'utf8'");
        mysqli_query($this->conexion,"SET CHARACTER SET 'utf8'");

        // creamos la variable para almacenar la consulta y mandarla a la base de datos
        $resultado = mysqli_query($this->conexion,$consulta);

        // verificamos que no haya ningun error
        if(!$resultado)
        {
            echo "Error en la consulta: ".mysqli_error($this->conexion);
        }

        // retornamos el valor del resultado
        return $resultado;

    }
    
    public function obtenerConexion()
    {
        return $this->conexion;
    }

}

?>