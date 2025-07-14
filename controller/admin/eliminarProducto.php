<?php
require '../../models/mySql.php';
try {
    $idProducto = $_POST['eliminarIdProducto'];
    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();

    $consulta = $conexion->prepare('update productos set estado = "Inactivo" where idProducto = :idProducto');
    $consulta->execute(['idProducto' => $idProducto]);

    $db->desconectar();

    header('Location: /cafeElBuenSabor/views/productos.php');
    exit;

} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}
?>