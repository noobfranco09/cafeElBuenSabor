<?php 

header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Método no permitido
    echo json_encode(["estado" => "Error", "mensaje" => "Método no permitido"]);
    exit();
}

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

if (!isset($datos['idMesa'])) {
    echo json_encode([
        "estado" => "Error",
        "mensaje" => "ID de mesa no recibido"
    ]);
    exit();
}

$idMesa = $datos['idMesa'];

try {
    $mysql = new MySQL();
    $mysql->conectar();
    $conexion = $mysql->obtenerConexion();

    $consulta = $conexion->prepare("UPDATE mesas SET estado = 'Inactiva' WHERE idMesa = ?");
    $consulta->execute([$idMesa]);

    $mysql->desconectar();

    echo json_encode([
        "estado" => "OK",
        "mensaje" => "Mesa desactivada correctamente",
        "idMesa" => $idMesa
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "estado" => "Error",
        "mensaje" => "Error en la base de datos: " . $e->getMessage()
    ]);
}

?>
