<?php

include '../functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarMesaAgregar();

if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../views/mesas.php");
    exit();
}

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$numeroMesa = $_POST["numeroMesa"];
$estadoMesa = $_POST["estadoMesa"];

$numeroMesaExitse = "SELECT * FROM mesas WHERE numero = ?";

$smts = $conexion->prepare($numeroMesaExitse);
$smts->execute([$numeroMesa]);

$mesaExistente = $smts->fetch(PDO::FETCH_ASSOC);

if ($mesaExistente) {
    header("location: ../views/mesas.php?Error=La_mesa_ya_existe.");
} else {

    $mesa = [
        "numero" => $numeroMesa,
        "estado" => $estadoMesa,
    ];

    $consulta = "INSERT INTO mesas (numero, estado) VALUES (:numero, :estado)";

    try {

        $smts = $conexion->prepare($consulta);
        $smts->execute($mesa);

        header("location: ../views/mesas.php");
                        
    } catch (PDOException $e) {
                        
        $errores[] = "Error al insertar: ". $e->getMessage();
        echo $e->getMessage();

    }
}

?>