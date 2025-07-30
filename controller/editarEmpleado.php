<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
    require_once BASE_PATH . 'functions/Validaciones.php';
    require_once BASE_PATH . 'models/mySql.php';

    session_start();

    $validaciones = new Validaciones($_POST);
    $errores = $validaciones->vldEditarEmpleado();

    $mysql = new MySQL();
    $mysql->conectar();

    if (!empty($errores)) {
        $_SESSION["erroresEditar"] = $errores;
        $_SESSION["abrirMdlEditar"] = true;

        // Si no hay errores de correo, obtenemos el ID según correo
        if (empty($errores["errorCorreo"]) && empty($errores["correoEnUso"])) {
            $consultaObtenerId = "SELECT idUsuario FROM usuario WHERE correo = :correo";
            $stmtObtenerId = $mysql->obtenerConexion()->prepare($consultaObtenerId);
            $stmtObtenerId->bindParam(":correo", $_POST["correo"], PDO::PARAM_STR);
            $stmtObtenerId->execute();
            $idObtenido = $stmtObtenerId->fetch(PDO::FETCH_ASSOC);
            $_SESSION["idEditar"] = $idObtenido["idUsuario"] ?? $_POST["id"];
        } else {
            $_SESSION["idEditar"] = $_POST["id"];
        }

        $mysql->desconectar();
        header("Location: " . BASE_URL . "views/empleados.php");
        exit();
    }

    // Preparar los datos para el UPDATE
    $datosUsuario = [
        ":nombre" => $_POST["nombre"],
        ":fechaIngreso" => $_POST["fecha"],
        ":telefono" => $_POST["telefono"],
        ":correo" => $_POST["correo"],
        ":idRoll" => $_POST["rol"],
        ":contrasena" => $_POST["contraseña"], // ⚠️ Considera aplicar hashing si es necesario
        ":estado" => $_POST["estado"],
        ":id" => $_POST["id"]
    ];

    $consulta = "UPDATE usuario SET 
        nombre = :nombre,
        fechaIngreso = :fechaIngreso,
        telefono = :telefono,
        correo = :correo,
        idRoll = :idRoll,
        contraseña = :contrasena,
        estado = :estado
    WHERE idUsuario = :id";

    try {
        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->execute($datosUsuario);
        $_SESSION["usrActualizado"] = true;
    } catch (PDOException $e) {
        $_SESSION["erroresEditar"][] = "Error al actualizar el usuario: " . $e->getMessage();
        $_SESSION["abrirMdlEditar"] = true;
        $_SESSION["idEditar"] = $_POST["id"];
    }

    $mysql->desconectar();
    header("Location: " . BASE_URL . "views/empleados.php");
    exit();

} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
    header("Location: " . BASE_URL . "views/empleados.php");
    exit();
}
