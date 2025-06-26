<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $input = file_get_contents("php://input");
    $data = json_decode($input,true);

    $id = $data["idUsuario"];

    require_once '../models/mySql.php';
    $mysql= new MySql();
    $mysql->conectar();
    $stmt=$mysql->obtenerConexion()->prepare('SELECT * FROM usuario WHERE idUsuario=:id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $mysql->desconectar();

 if($usuario){
    echo json_encode([
        "estado"=>"OK",
        "datosUsuario"=> $usuario
    ]);
 }
 else{
    echo json_encode([
        "estado"=>"ERROR",
    ]);
 }
}
else{
    exit;
}

?>