<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';
require_once BASE_PATH . 'models/mySql.php';

session_start();

$validaciones = new Validaciones($_POST);
$errores = $validaciones->validarMesaEditar();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/mesas.php");
    exit();
}

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$idMesa = $_POST['idMesaEditar'];
$numeroMesa = $_POST['numeroMesaEditar'];
$estadoMesa = $_POST['estadoMesaEditar'];

// Verificar si ya existe otra mesa con ese número
$consultaExistencia = "SELECT 1 FROM mesas WHERE numero = :numero AND idMesa != :idMesa";
$stmt = $conexion->prepare($consultaExistencia);
$stmt->execute([
    ':numero' => $numeroMesa,
    ':idMesa' => $idMesa
]);

if ($stmt->fetch()) {
    $_SESSION["old"] = $_POST;
    $_SESSION["errores"] = ["numero" => "Ya existe una mesa con ese número."];
    $mysql->desconectar();
    header("Location: " . BASE_URL . "views/mesas.php");
    exit();
}

// Actualizar la mesa
$consultaUpdate = "UPDATE mesas SET numero = :numero, estado = :estado WHERE idMesa = :idMesa";
try {
    $stmt = $conexion->prepare($consultaUpdate);
    $stmt->execute([
        ':numero' => $numeroMesa,
        ':estado' => $estadoMesa,
        ':idMesa' => $idMesa
    ]);

    $_SESSION["mesaActualizada"] = true;
    $mysql->desconectar();
    header("Location: " . BASE_URL . "views/mesas.php");
    exit();

} catch (PDOException $e) {
    $_SESSION["errores"] = ["db" => "Error al actualizar la mesa: " . $e->getMessage()];
    $_SESSION["old"] = $_POST;
    $mysql->desconectar();
    header("Location: " . BASE_URL . "views/mesas.php");
    exit();
}
?>
