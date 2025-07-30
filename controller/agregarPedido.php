<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

header('Content-Type: application/json');

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

$notaObj = json_decode($datos['nota'], true);
$nota = $notaObj['nota'] ?? '';

// Remover la nota del array para que el foreach solo procese productos
unset($datos['nota']);

foreach ($datos as $idProducto => $productoJsonString) {
    $producto = json_decode($productoJsonString, true);

    // Extraer datos
    $nombre = $producto['nombre'];
    $precio = $producto['precio'];
    $cantidad = $producto['cantidad'];
    $stock = $producto['stock'];
    $carta = $producto['carta'];

    // Aquí puedes insertar o procesar cada producto en la base de datos
    // TODO: Agregar lógica si se necesita guardar o actualizar cada producto
}

// Eliminar la carta y desactivarla
$codigo = $carta;
$consulta = "UPDATE qr SET estado = 'Inactivo' WHERE codigo = :codigo";
$desactivarQr = $conexion->prepare($consulta);
$desactivarQr->bindParam(":codigo", $codigo, PDO::PARAM_STR);
$desactivarQr->execute();

// Eliminar archivo QR
$obtenerUrl = $conexion->prepare("SELECT * FROM qr WHERE codigo = :codigo");
$obtenerUrl->execute(['codigo' => $codigo]);
$data = $obtenerUrl->fetch(PDO::FETCH_ASSOC);
$url = "." . $data["url"];
if (file_exists($url)) {
    unlink($url);                    
}           

$mysql->desconectar();

// Retornar respuesta
echo json_encode([
    'nombre' => $nombre,
    'precio' => $precio,
    'cantidad' => $cantidad,
    'stock' => $stock,
    'carta' => $carta,
    'nota' => $nota
]);
?>
