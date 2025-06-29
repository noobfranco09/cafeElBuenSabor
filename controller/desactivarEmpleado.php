<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
$input = file_get_contents("php://input");
$data = json_decode($input,true);

$id = $data["idUsuario"] ?? "";


require_once '../models/mySql.php';

$mysql = new Mysql;
$mysql->conectar();
$consulta = "UPDATE usuario SET estado ='Inactivo' WHERE idUsuario=:idUsuario ";
$stmt=$mysql->obtenerConexion()->prepare($consulta);
$stmt->bindParam(":idUsuario",$id,PDO::PARAM_INT);
$stmt->execute();

echo json_encode([
    "estado"=>"OK",
    "redireccion"=>"../views/empleados.php"
]);
}
else{
    exit;
}
?>