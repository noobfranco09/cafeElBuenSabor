<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';

session_start();

$validaciones = new Validaciones($_POST);
$errores = $validaciones->validarRolEditar();

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

    header("Location: " . BASE_URL . "views/rol.php");

} catch (PDOException $e) {
    $errores[] = "Error al insertar: " . $e->getMessage();
    echo $e->getMessage(); // ⚠️ Esto puede exponer errores en producción. Considera registrar en log.
}
?>
