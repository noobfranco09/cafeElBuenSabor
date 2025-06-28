<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
require_once '../functions/Validaciones.php';
require_once '../models/mySql.php';
$validaciones = new Validaciones($_POST);
$mysql = new MySQL();
$errores =$validaciones->vldEditarEmpleado();
$mysql->conectar();
session_start();
if(!empty($errores)){
    
    
    $_SESSION["erroresEditar"]=$errores;
    $_SESSION["abirMdlEditar"]=true;
    if(empty($errores["errorCorreo"]) && empty($errores["correoEnUso"])){
        $consultaObtenerId = "SELECT idUsuario FROM usuario WHERE correo=:correo";
        $stmtObtenerId = $mysql->obtenerConexion()->prepare($consultaObtenerId);
        $stmtObtenerId->bindParam(":correo",$_POST["correo"],PDO::PARAM_STR);
        $stmtObtenerId->execute();
        $idObtenido = $stmtObtenerId->fetch(PDO::FETCH_ASSOC);
        $_SESSION["idEditar"]=$idObtenido["idUsuario"];
        header("location: ../views/empleados.php");
        exit();
    }
    $_SESSION["idEditar"]=$_POST["id"];
    header("location: ../views/empleados.php");
    exit();
}



$datosUsuario = [
":nombre"=>$_POST["nombre"],
":fechaIngreso"=>$_POST["fecha"],
":telefono"=>$_POST["telefono"],
":correo"=>$_POST["correo"],
":idRoll"=>$_POST["rol"],
":contrasena"=>$_POST["contraseña"],
":estado"=>$_POST["estado"],
":id"=>$_POST["id"]
];

$consulta = "UPDATE usuario SET 
    nombre = :nombre,
    fechaIngreso = :fechaIngreso,
    telefono = :telefono,
    correo = :correo,
    idRoll = :idRoll,
    contraseña = :contrasena,
    estado = :estado
WHERE idUsuario = :id";

$stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->execute($datosUsuario);
        header("Location:../views/empleados.php");
        $_SESSION["usrActualizado"]=true;
            $mysql->desconectar();
                exit();


}
else{
    header("Location:../views/empleados.php");
    exit();
}
?>