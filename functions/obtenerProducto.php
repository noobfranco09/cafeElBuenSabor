<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$id = $datos['idProducto'];

$consulta = $conexion->prepare("SELECT * FROM productos WHERE idProducto = ?");
$consulta->execute([$id]);

$resultado =  $consulta->fetch(PDO::FETCH_ASSOC);

$mysql->desconectar();

header('Content-Type: application/json');
echo json_encode($resultado);

?>