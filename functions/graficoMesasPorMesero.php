<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerProductosMasVendidos = $conexion->query("SELECT usuario.nombre , count(pedidos.idUsuario) As cantidadMesasAtendidas FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido 
JOIN usuario ON usuario.idUsuario = pedidos.idUsuario
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto GROUP BY usuario.nombre
ORDER BY cantidadMesasAtendidas DESC");

$data = $obtenerProductosMasVendidos->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>