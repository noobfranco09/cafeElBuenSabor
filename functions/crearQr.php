<?php
require '.././libraries/phpqrcode/qrlib.php';
require '../models/mySql.php';


function generarQr($idMesa)
{
    $carpeta = '../assets/Qrs';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, recursive: true);
    }

    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();



    $codigo = 'carta' . uniqid();
    $horaInicio = date('Y-m-d H:i:s');
    $duracionQr = 10;
    $horaFinal = date('Y-m-d H:i:s', strtotime("+$duracionQr minutes"));
    $url = "localhost:3000/index.php?qr=$codigo&mesa=$idMesa";
    $ubicacionQr = $carpeta . "/$codigo.png";
    $qr = [
        "url" => "./assets/Qrs"."/$codigo.png",
        "codigo"=>$codigo,
        "horaInicio" => $horaInicio,
        "horaFinal" => $horaFinal,
        "estado" => 'Activo'
    ];

    $consulta = $conexion->prepare('insert into qr (url,codigo,horaInicio,horaFinal,estado) values (:url,:codigo,:horaInicio,:horaFinal,:estado)');

    if (!$consulta->execute($qr)) {
        die("error al insertar en la base de datos");
    }
    $db-> desconectar();
    try{
        QRcode::png($url, $ubicacionQr);
        return $ubicacionQr;
    }catch(Throwable $e){
        return "error";
    }
    
        
}





?>