<?php 

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true);


$pedido = json_decode($datos[1],true);
// la varible $datos es la que tiene ya toda la informacion del localSotage y esta lista para manipular

// aqui ya puede implementar la logica para lo que necesite

// NOTA: para entender mejor los datos que le llegan mire el LocarStorage y la estructura que tenga sera la misma la que recibe la varible $datos

//Para eliminar la carta y desactivarla

$codigo = $pedido["carta"];
$consulta = "UPDATE qr SET estado = 'Inactivo' WHERE codigo = :codigo";
$desactivarQr = $conexion->prepare($consulta);
$desactivarQr->bindParam(":codigo",$codigo,PDO::PARAM_STR);
$desactivarQr->execute();
//-----Eliminamos el qr-----------------------//
$obtenerUrl = $conexion->prepare("SELECT * FROM qr WHERE codigo =:codigo");
$obtenerUrl->execute(['codigo' => $codigo]);
$data = $obtenerUrl->fetch(PDO::FETCH_ASSOC);
$url = ".".$data["url"];
 if(file_exists($url)){
unlink($url);                    
}           
               




$mysql->desconectar();

// esta parte retorna el resultado de la operacion que se realizo
header('Content-Type: application/json');
echo json_encode($datos);

?>