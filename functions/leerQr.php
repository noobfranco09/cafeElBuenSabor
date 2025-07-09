<?php

function verificarQr($codigo)
{

   

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
        $fechaInicio = new DateTime($resultado['horaInicio']);
        $fechaFinal = new DateTime($resultado['horaFinal']);
        $fecha = new DateTime();
        $fechaActual = $fecha->format("Y-m-d H:i:s");
        if ($resultado['estado'] == 1 && $fechaActual > $fechaFinal->format("Y-m-d H:i:s")) {
            try {

                
                $consulta2 = $conexion->prepare('update qr set estado = 0 where codigo = :codigo');
                $consulta2->execute(['codigo' => $codigo]);

                $obtenerUrl = $conexion->prepare("SELECT * FROM qr WHERE codigo =:codigo");
                $obtenerUrl->execute(['codigo' => $codigo]);
                $data = $obtenerUrl->fetch(PDO::FETCH_ASSOC);
                $url = $data["url"];
                echo $url;
                if(file_exists($url)){
                    unlink($url);
                    echo "Borrado";
                }


                 exit();
            } catch (PDOException) {
                die('error en la consulta');
            }


        } else {
           return true;
        }
    } else {
        die('Qr inválido');
    }
}
;
?>