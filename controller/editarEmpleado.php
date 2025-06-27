<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
require_once '../functions/Validaciones.php';
$validaciones = new Validaciones($_POST);
$errores =$validaciones->vldEditarEmpleado();

if(!empty($errores)){
    session_start();
    
    $_SESSION["erroresEditar"]=$errores;
    header("location: ../views/empleados.php");
}
}
else{
    header("Location:../views/empleados.php");
    exit();
}
?>