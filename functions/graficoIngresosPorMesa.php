<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerIngresoPorMesa = $conexion->query("SELECT mesas.numero , sum(ventas.total) As ingresoMesa FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido 
JOIN mesas ON mesas.idMesa = pedidos.idMesa
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto GROUP BY mesas.numero
ORDER BY ingresoMesa DESC");

$data = $obtenerIngresoPorMesa->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>