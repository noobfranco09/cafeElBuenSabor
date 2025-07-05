<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $input = file_get_contents("php://input");
    $data = json_decode($input,true);
 require '../functions/crearQr.php';
    
        $idMesa = $data["idMesa"];
        $ubicacionQr = generarQr($idMesa);
        if($ubicacionQr!="error"){
            echo json_encode([
                'data'=>$ubicacionQr,
                'mesa'=>$idMesa
            ]);
            exit();
        }else{
            echo json_encode([
                'data'=>'Ocurrio un error'
            ]);
            exit();
        }
    
   
    
}else{
    header("location: ../views/generarQr.php");
    exit();
}

?>