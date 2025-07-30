<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'libraries/phpqrcode/qrlib.php';
require_once BASE_PATH . 'models/mySql.php';

function generarQr($idMesa)
{
    $carpeta = BASE_PATH . 'assets/Qrs';
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
    
    $url = 'http://localhost' . BASE_URL . 'index.php?qr=' . $codigo . '&mesa=' . $idMesa;
    $ubicacionQr = $carpeta . "/$codigo.png";

    $qr = [
        "url" => BASE_URL . "assets/Qrs/$codigo.png",
        "codigo" => $codigo,
        "horaInicio" => $horaInicio,
        "horaFinal" => $horaFinal,
        "estado" => 'Activo'
    ];

    $consulta = $conexion->prepare('INSERT INTO qr (url, codigo, horaInicio, horaFinal, estado) VALUES (:url, :codigo, :horaInicio, :horaFinal, :estado)');

    if (!$consulta->execute($qr)) {
        die("Error al insertar en la base de datos");
    }

    $db->desconectar();

    try {
        QRcode::png($url, $ubicacionQr);
        return $ubicacionQr;
    } catch (Throwable $e) {
        return "error";
    }
}
?>
