<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarRolAgregar();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/rol.php");
    exit();
}

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$nombreRol = $_POST["nombreRol"];
$descripcionRol = $_POST["descripcionRol"];

$rol = [
    "nombre" => $nombreRol,
    "descripcion" => $descripcionRol,
];

$consulta = "INSERT INTO roles (nombre, descripcion, estado) VALUES (:nombre, :descripcion, 'SinVincular')";

try {
    $smts = $conexion->prepare($consulta);
    $smts->execute($rol);

    header("Location: " . BASE_URL . "views/rol.php");

} catch (PDOException $e) {
    $errores[] = "Error al insertar: " . $e->getMessage();
    echo $e->getMessage();
}
?>
