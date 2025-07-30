<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';

session_start();

$validaciones = new Validaciones($_POST);
$errores = $validaciones->validarCategoriaAgregar();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/categorias.php");
    exit();
}

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$nombreCategoria = $_POST["nombreCategoria"];
$descripcionCategoria = $_POST["descripcionCategoria"];

$categoria = [
    "nombre" => $nombreCategoria,
    "descripcion" => $descripcionCategoria,
];

$consulta = "INSERT INTO categorias (nombre, descripcion, estado) VALUES (:nombre, :descripcion, 'Activa')";

try {
    $smts = $conexion->prepare($consulta);
    $smts->execute($categoria);

    header("Location: " . BASE_URL . "views/categorias.php");
    exit();
} catch (PDOException $e) {
    $errores[] = "Error al insertar: " . $e->getMessage();
    echo $e->getMessage();
}
?>
