<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerMesasPorMesero = $conexion->query("SELECT mesas.numero , count(pedidos.idMesa) As cantidadMesasAtendidas FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN usuario ON usuario.idUsuario = pedidos.idUsuario
JOIN roles  ON roles.idRoll = usuario.idRoll
JOIN mesas ON mesas.idMesa = pedidos.idMesa
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto WHERE roles.nombre = 'mesero' GROUP BY mesas.numero
ORDER BY cantidadMesasAtendidas DESC");

$data = $obtenerMesasPorMesero->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve el resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$mysql->desconectar();

?>