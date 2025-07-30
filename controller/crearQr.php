<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    require_once BASE_PATH . 'functions/crearQr.php';

    $idMesa = $data["idMesa"];
    $ubicacionQr = generarQr($idMesa);

    if ($ubicacionQr != "error") {
        $mysql = new MySQL;
        $mysql->conectar();

        $consulta = "UPDATE mesas SET estado = 'Ocupada' WHERE idMesa = :id";
        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(":id", $idMesa, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode([
            'data' => $ubicacionQr,
            'mesa' => $idMesa
        ]);
        exit();
    } else {
        echo json_encode([
            'data' => 'Ocurrio un error'
        ]);
        exit();
    }

} else {
    header("Location: " . BASE_URL . "views/generarQr.php");
    exit();
}

?>
