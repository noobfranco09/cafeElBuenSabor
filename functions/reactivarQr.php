<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $input = file_get_contents("php://input");
    $data = json_decode($input,true);
    require_once '../models/mySql.php';
    $id = $data["idMesa"];
    $mysql = new MySQL;
    $mysql->conectar();
    
    $consulta = "UPDATE mesas set estado = 'Activa' WHERE idMesa = :id";

    $stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

   if($stmt){
     echo json_encode(["success"=>"true"]);
   }
   else{
     echo json_encode(["success"=>"false"]);
   }
    
    
    

}
?>