<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){

session_start();
include '../../models/Validaciones.php';

$validacions = new Validaciones($_POST);

$errores =$validacions->validarDatos();
//Esto devuleve los errorse para mostrarlosdesde el login
if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../../views/login.php");
    exit();
}

    header("location: ../../views/index.php");
    exit();


}
else{
    header("location: ../../views/login.php");
    exit();
}
?>