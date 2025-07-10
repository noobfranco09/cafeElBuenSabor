<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$id = $datos['idVenta'];

$consulta = $conexion->prepare("SELECT ventas.pedidos_idPedido, DATE_FORMAT(ventas.fecha, '%Y-%m-%d') As fecha, ventas.total, mesas.numero, productos.nombre, productos_has_pedidos.cantidad,
productos_has_pedidos.nota, productos_has_pedidos.precioVenta FROM ventas
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto
JOIN mesas ON mesas.idMesa = pedidos.idMesa WHERE idVenta = ?");

$consulta->execute([$id]);

$resultado =  $consulta->fetchAll(PDO::FETCH_ASSOC);

$mysql->desconectar();

header('Content-Type: application/json');
echo json_encode($resultado);

?>