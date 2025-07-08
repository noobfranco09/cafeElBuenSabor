<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$idMesa = $datos['idMesa'];

$consulta = $conexion->prepare("UPDATE mesas SET estado = 'Inactiva' WHERE idMesa = ?");
$consulta->execute([$idMesa]);

$mysql->desconectar();

header('Content-Type: application/json');
echo json_encode($resultado);

?>