<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
session_start();
require_once '../functions/Validaciones.php';

$validaciones = new Validaciones($_POST);
$errores = $validaciones->vldCrearEmpleado();
if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("Location: ../views/empleados.php");
    exit();
}

}else{
    header("Location: ../views/empleados.php");
    exit();
}


?>
