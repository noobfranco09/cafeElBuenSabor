<?php

include '../functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarCategoriaEditar();

if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../views/categorias.php");
    exit();
}

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$idCategoria = $_POST["idCategoriaEditar"];
$nombreCategoriaEditar = $_POST["nombreCategoriaEditar"];
$descripcionCategoriaEditar = $_POST["descripcionCategoriaEditar"];
$estadoCategoriaEditar = $_POST["estadoCategoriaEditar"];

$categoria = [
    "idCategoria" => $idCategoria,
    "nombre" => $nombreCategoriaEditar,
    "descripcion" => $descripcionCategoriaEditar,
    "estado" => $estadoCategoriaEditar
];

$consulta = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE idCategoria = :idCategoria";

try {

    $smts = $conexion->prepare($consulta);
    $smts->execute($categoria);

    header("location: ../views/categorias.php");
                    
} catch (PDOException $e) {
                    
    $errores[] = "Error al insertar: ". $e->getMessage();
    echo $e->getMessage();

}


?>