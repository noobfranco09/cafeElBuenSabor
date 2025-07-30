<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'models/mySql.php';

try {
    $idProducto = $_POST['eliminarIdProducto'];
    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();

    $consulta = $conexion->prepare('UPDATE productos SET estado = "Inactivo" WHERE idProducto = :idProducto');
    $consulta->execute(['idProducto' => $idProducto]);

    $db->desconectar();

    header('Location: ' . BASE_URL . 'views/productos.php');
    exit;

} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}
?>
