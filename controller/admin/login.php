<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){

session_start();
require_once '../../functions/Validaciones.php';



$validacions = new Validaciones($_POST);

$errores =$validacions->validarDatos();
//Esto devuleve los errorse para mostrarlosdesde el login
if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../../views/login.php");
    exit();
}
    require_once '../../models/mySql.php';
    $mysql = new MySQL();

    $mysql->conectar();
    $correo = $_POST["correo"];

    $consulta = 
    "SELECT usuario.idUsuario,usuario.nombre,roles.nombre AS rol FROM  usuario JOIN roles ON roles.idRoll = usuario.IdRoll WHERE correo = :correo";

    $stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->bindParam(':correo',$correo,PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION["id"]= $resultado["idUsuario"];
    $_SESSION["nombre"]=$resultado["nombre"];
    $_SESSION["rol"]=$resultado["rol"];

    $mysql->desconectar();
    header("Location: ../../views/dashboard.php");
    



}
else{
    header("location: ../../views/login.php");
    exit();
}
?>