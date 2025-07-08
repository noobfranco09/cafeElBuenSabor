<?php

include '../functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarMesaEditar();

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

$idMesaEditar = $_POST['idMesaEditar'];
$numeroMesaEditar = $_POST["numeroMesaEditar"];
$estadoMesaEditar = $_POST["estadoMesaEditar"];

$numeroMesaExitse = "SELECT * FROM mesas WHERE numero = ? AND idMesa != ?";

$smts = $conexion->prepare($numeroMesaExitse);
$smts->execute([$numeroMesaEditar, $idMesaEditar]);

$mesaExistente = $smts->fetch(PDO::FETCH_ASSOC);

if ($mesaExistente) {
    header("location: ../views/mesas.php?Error=La_mesa_ya_existe.");
} else {

    $mesa = [
        "idMesa" => $idMesaEditar,
        "numero" => $numeroMesaEditar,
        "estado" => $estadoMesaEditar,
    ];

    $consulta = "UPDATE mesas SET numero = :numero, estado = :estado WHERE idMesa = :idMesa";

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