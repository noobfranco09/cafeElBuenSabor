<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerProductosMasVendidos = $conexion->query("SELECT productos.nombre , count(productos_has_pedidos.idProducto) As cantidadProductos FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido 
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto GROUP BY productos.nombre
ORDER BY cantidadProductos DESC LIMIT 3");

$data = $obtenerProductosMasVendidos->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>