<?php
require '../models/mySql.php';
function verificarQr($codigo)
{

    if (!isset($codigo) || empty($codigo)) {
        die("codigo inexistente");
    }

    $db = new MySQL();
    $db->conectar();
    try {
        $conexion = $db->obtenerConexion();
        $consulta = $conexion->prepare('select * from qr where codigo = ?');
        $consulta->execute([$codigo]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException) {
        die('error en la consulta');
    }


    if ($resultado) {
        $fechaInicio = new DateTime($resultado['fechaInicio']);
        $fechaFinal = new DateTime($resultado['fechaFinal']);
        $fechaActual = new DateTime();
        if ($resultado['estado'] == 1 && $fechaActual >= $fechaInicio && $fechaActual < $fechaFinal) {
            try {
                $consulta2 = $conexion->prepare('update qr set estado = 0 where codigo = :codigo');
                $consulta2->execute(['codigo' => $codigo]);
                return true;
            } catch (PDOException) {
                die('error en la consulta');
            }


        } else {
            return false;
        }
    } else {
        die('Qr inválido');
    }
}
;
?>