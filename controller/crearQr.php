<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
 require '../functions/crearQr.php';
    if(isset($_POST["mesa"]) && filter_var($_POST["mesa"],FILTER_VALIDATE_INT)){
        $idMesa = $_POST["mesa"];
        if(generarQr($idMesa)){
            header("location: ../views/generarQr.php");
            exit(); 
        }else{
            header("location: ../views/generarQr.php");
            exit(); 
            //Por errror
        }
    }
    else{
    header("location: ../views/generarQr.php");
    exit();
    }
    
}else{
    header("location: ../views/generarQr.php");
    exit();
}

?>