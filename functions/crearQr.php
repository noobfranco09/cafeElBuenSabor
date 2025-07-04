<?php
require '.././libraries/phpqrcode/qrlib.php';
require '../models/mySql.php';


function generarQr($mesa)
{
    $carpeta = '../assets/images';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, recursive: true);
    }

    $idMesa = [
        "idMesa" => $mesa
    ];
    
    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();



    $codigo = 'carta' . uniqid();
    $horaInicio = date('Y-m-d H:i:s');
    $duracionQr = 10;
    $horaFinal = date('Y-m-d H:i:s', strtotime("+$duracionQr minutes"));
    $url = "https://localhost:8080/cartaProductos.php?qr=$codigo";
    $ubicacionQr = $carpeta . "/$codigo.png";
    $qr = [
        "url" => $ubicacionQr,
        "codigo"=>$codigo,
        "horaInicio" => $horaInicio,
        "horaFinal" => $horaFinal,
        "estado" => 1
    ];

    $consulta = $conexion->prepare('insert into qr (url,codigo,horaInicio,horaFinal,estado) values (:url,:codigo,:horaInicio,:horaFinal,:estado)');

    if (!$consulta->execute($qr)) {
        die("error al insertar en la base de datos");
    }
    $db-> desconectar();
    try{
        QRcode::png($url, $ubicacionQr);
        return true;
    }catch(Throwable $e){
        return false;
    }
    
        
}





?>