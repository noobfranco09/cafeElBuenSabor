<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
session_start();
require_once '../functions/Validaciones.php';

$validaciones = new Validaciones($_POST);
$errores = $validaciones->vldCrearEmpleado();
if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    $_SESSION["abrirModal"]=true;
    header("Location: ../views/empleados.php");
    exit();
}
require_once '../models/mySql.php';
$mysql = new MySQL;
$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$rol = $_POST["rol"];
$contraseña = $_POST["contraseña"];
$estado = "Activo";

$consulta = "INSERT INTO usuario (nombre,fechaIngreso,telefono,correo,idRoll,contraseña,estado) values (:nombre,:fecha,:telefono,:correo,:rol,:contrasena,:estado)";
$mysql->conectar();

$stmt= $mysql->obtenerConexion()->prepare($consulta);

$stmt->bindParam(":nombre",$nombre,PDO::PARAM_STR);
$stmt->bindParam(":fecha",$fecha,PDO::PARAM_STR);
$stmt->bindParam(":telefono",$telefono,PDO::PARAM_STR);
$stmt->bindParam(":correo",$correo,PDO::PARAM_STR);
$stmt->bindParam(":rol",$rol,PDO::PARAM_INT);
$stmt->bindParam(":contrasena",$contraseña,PDO::PARAM_STR);
$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
$stmt->execute();
$mysql->desconectar();

header("Location: ../views/empleados.php");
exit();

}else{
    header("Location: ../views/empleados.php");
    exit();
}


?>
