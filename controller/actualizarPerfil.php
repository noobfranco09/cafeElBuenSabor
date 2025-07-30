<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    session_start();
    require_once BASE_PATH . 'functions/validaciones.php';
    $validaciones = new Validaciones($_POST);

    $errores =$validaciones->vldActualizarPerfil();

    if(!empty($errores)){
     $_SESSION["errores"]=$errores;
     $_SESSION["old"]=$_POST;
     header("location: ../views/perfil.php");
     exit();   
    }

    $id = $_SESSION["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];

    $datosUsuario =[
        ":nombre"=>$nombre,
        ":correo"=>$correo,
        ":telefono"=>$telefono,
        ":id"=>$id
    ];

    require_once '../models/mySql.php';
    $consulta = "UPDATE usuario SET nombre = :nombre, correo=:correo,telefono=:telefono WHERE idUsuario=:id";
    $mysql = new MySQL;
    $mysql->conectar();
    try{
    $stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->execute($datosUsuario);
    $_SESSION["nombre"]=$nombre;
     header("location: ../views/perfil.php");
     exit();         
    }
    catch(PDOException $e){
        $errores["errorPerfil"] = "Ocurrio un error inesperado ";
        $_SESSION["errores"]=$errores;
        header("location: ../views/perfil.php");
        exit();    
    }
    
    




}
?>