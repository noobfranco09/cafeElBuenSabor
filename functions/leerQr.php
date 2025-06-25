<?php
require '../models/mySql.php';
require './funcionSanitizar.php';
function verificarQr($codigo)
{

    if (!isset($codigo) && empty($codigo)) {
        die("codigo inexistente");
    }

    $db = new MySQL();
    $db->conectar();
    $conexion = $db->obtenerConexion();
    $consulta = $conexion->prepare('select * from qr where codigo = ?');
    $consulta->execute([$codigo]);
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($resultado) 
    {

    } else {
        die('Qr inválido');
    }
}
;
?>