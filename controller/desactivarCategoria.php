<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

header('Content-Type: application/json');

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);

if (!isset($datos['idCategoria'])) {
    echo json_encode(['error' => 'ID de categoría no proporcionado']);
    exit();
}

$idCategoria = $datos['idCategoria'];

try {
    $consulta = $conexion->prepare("UPDATE categorias SET estado = 'Inactiva' WHERE idCategoria = ?");
    $consulta->execute([$idCategoria]);

    $resultado = [
        'success' => true,
        'message' => "Categoría $idCategoria desactivada correctamente."
    ];

} catch (PDOException $e) {
    $resultado = [
        'success' => false,
        'message' => 'Error al actualizar la categoría: ' . $e->getMessage()
    ];
}

$mysql->desconectar();

echo json_encode($resultado);

?>
