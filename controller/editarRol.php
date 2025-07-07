<?php

include '../functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarRolEditar();

if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../views/rol.php");
    exit();
}

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$idRolEditar = $_POST['idRolEditar'];
$nombreRolEditar = $_POST["nombreRolEditar"];
$descripcionRolEditar = $_POST["descripcionRolEditar"];

$rol = [
    "idRoll" => $idRolEditar,
    "nombre" => $nombreRolEditar,
    "descripcion" => $descripcionRolEditar,
];

$consulta = "UPDATE roles SET nombre = :nombre, descripcion = :descripcion WHERE idRoll = :idRoll";

try {

    $smts = $conexion->prepare($consulta);
    $smts->execute($rol);

    header("location: ../views/rol.php");
                    
} catch (PDOException $e) {
                    
    $errores[] = "Error al insertar: ". $e->getMessage();
    echo $e->getMessage();

}


?>