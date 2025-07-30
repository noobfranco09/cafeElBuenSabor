<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
    require_once BASE_PATH . 'functions/Validaciones.php';

    $validacions = new Validaciones($_POST);
    $errores = $validacions->validarDatos();

    // Si hay errores, redirigir al login con errores y datos antiguos
    if (!empty($errores)) {
        $_SESSION["errores"] = $errores;
        $_SESSION["old"] = $_POST;
        header("Location: " . BASE_URL . "views/login.php");
        exit();
    }

    require_once BASE_PATH . 'models/mySql.php';
    $mysql = new MySQL();

    $mysql->conectar();
    $correo = $_POST["correo"];

    $consulta = "
        SELECT usuario.idUsuario, usuario.nombre, usuario.estado, roles.nombre AS rol
        FROM usuario
        JOIN roles ON roles.idRoll = usuario.IdRoll
        WHERE correo = :correo
    ";

    $stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION["id"] = $resultado["idUsuario"];
    $_SESSION["nombre"] = $resultado["nombre"];
    $_SESSION["rol"] = $resultado["rol"];
    $_SESSION["estado"] = $resultado["estado"];

    $mysql->desconectar();

    header("Location: " . BASE_URL . "views/dashboard.php");
    exit();

} else {
    header("Location: " . BASE_URL . "views/login.php");
    exit();
}
?>
