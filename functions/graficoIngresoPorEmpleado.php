<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerMesasPorMesero = $conexion->query("SELECT usuario.nombre , sum(ventas.total) As ingresoPorEmpelado FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN usuario ON usuario.idUsuario = pedidos.idUsuario
JOIN roles  ON roles.idRoll = usuario.idRoll
JOIN mesas ON mesas.idMesa = pedidos.idMesa
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto GROUP BY usuario.nombre
ORDER BY ingresoPorEmpelado DESC");

$data = $obtenerMesasPorMesero->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>