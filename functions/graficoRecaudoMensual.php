<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerIngresoPorFecha = $conexion->query("SELECT DATE_FORMAT(ventas.fecha, '%Y-%m') as fechaMes , sum(ventas.total) As ingresoMes FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto GROUP BY fechaMes
ORDER BY ingresoMes DESC");

$data = $obtenerIngresoPorFecha->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>