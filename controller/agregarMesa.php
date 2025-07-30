<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';

session_start();

$validaciones = new Validaciones($_POST);
$errores = $validaciones->validarMesaAgregar();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/mesas.php");
    exit();
}

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$numeroMesa = $_POST["numeroMesa"];
$estadoMesa = $_POST["estadoMesa"];

$numeroMesaExiste = "SELECT * FROM mesas WHERE numero = ?";
$smts = $conexion->prepare($numeroMesaExiste);
$smts->execute([$numeroMesa]);

$mesaExistente = $smts->fetch(PDO::FETCH_ASSOC);

if ($mesaExistente) {
    header("Location: " . BASE_URL . "views/mesas.php?Error=La_mesa_ya_existe.");
} else {
    $mesa = [
        "numero" => $numeroMesa,
        "estado" => $estadoMesa,
    ];

    $consulta = "INSERT INTO mesas (numero, estado) VALUES (:numero, :estado)";

    try {
        $smts = $conexion->prepare($consulta);
        $smts->execute($mesa);

        header("Location: " . BASE_URL . "views/mesas.php");

    } catch (PDOException $e) {
        $errores[] = "Error al insertar: " . $e->getMessage();
        echo $e->getMessage();
    }
}
?>
