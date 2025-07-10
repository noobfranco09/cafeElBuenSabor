<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$idCategoria = $datos['idCategoria'];

$consulta = $conexion->prepare("UPDATE categorias SET estado = 'Inactiva' WHERE idCategoria = ?");
$consulta->execute([$idCategoria]);

$mysql->desconectar();

header('Content-Type: application/json');
echo json_encode($resultado);

?>