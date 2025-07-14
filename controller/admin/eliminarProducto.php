<?php
require '../../models/mySql.php';
try {
    $idProducto = $_POST['eliminarIdProducto'];
    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();

    $consulta = $conexion->prepare('update productos set estado = 0 where idProducto = :idProducto');
    $consulta->execute(['idProducto' => $idProducto]);

    $db->desconectar();

    header("Refresh :3; URL=../../views/dashBoard.php");
    echo "Eliminado con éxito";
    exit;

} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}
?>