<?php 
include "../models/mySql.php";
$db= new MySQL();
$db->conectar();
$conexion=$db->obtenerConexion();

try {
    $consulta=$conexion->query("select * from categorias");
    $categorias=$consulta->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($categorias);
} catch (PDOException $e) {
        http_response_code(500);
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>