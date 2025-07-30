<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$idRoll = $datos['idRoll'];

$consulta = $conexion->prepare("DELETE FROM roles WHERE idRoll = ?");
$consulta->execute([$idRoll]);

$resultado = [
    'success' => true,
    'message' => 'Rol eliminado correctamente'
];

$mysql->desconectar();

header('Content-Type: application/json');
echo json_encode($resultado);

?>
