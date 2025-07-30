<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json');

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!isset($data["idUsuario"])) {
        echo json_encode([
            "estado" => "Error",
            "mensaje" => "ID de usuario no proporcionado"
        ]);
        exit();
    }

    $id = $data["idUsuario"];

    // No se puede desactivar a sí mismo
    if ($id == $_SESSION["id"]) {
        echo json_encode([
            "estado" => "Indesactivable",
            "redireccion" => "../views/empleados.php"
        ]);
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
    require_once BASE_PATH . 'models/mySql.php';

    try {
        $mysql = new MySQL();
        $mysql->conectar();

        $consulta = "UPDATE usuario SET estado = 'Inactivo' WHERE idUsuario = :idUsuario";
        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(":idUsuario", $id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode([
            "estado" => "OK",
            "redireccion" => "../views/empleados.php"
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "estado" => "Error",
            "mensaje" => "Error al desactivar el usuario: " . $e->getMessage()
        ]);
    }

} else {
    http_response_code(405); // Método no permitido
    exit();
}
