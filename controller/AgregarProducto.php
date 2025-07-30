<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarProducto();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/productos.php");
    exit();
}

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();

$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];
$categoria = $_POST["categoria"];
$estado = $_POST["estado"];
$descripcion = $_POST["descripcion"];

if ($_FILES['imagen'] && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagenesPermitidas = ['image/jpg' => '.jpg', 'image/png' => '.png', 'image/jpeg' => '.jpeg'];
    $tipoImagen = mime_content_type($_FILES['imagen']['tmp_name']);

    if (!array_key_exists($tipoImagen, $imagenesPermitidas)) {
        $errores["imagenNoPermitida"] = "Solo se permiten imágenes JPEG, JPG y PNG.";
        $_SESSION["errores"] = $errores;
        $_SESSION["old"] = $_POST;
        header("Location: " . BASE_URL . "views/productos.php");
        exit();
    }

    $extension = $imagenesPermitidas[$tipoImagen];
    $nombreImagen = 'imagen_' . date('Ymd_Hisv') . $extension;
    $ruta = 'assets/imgProductos/' . $nombreImagen;
    $rutaAbsoluta = BASE_PATH . $ruta;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
        $producto = [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "stock" => $stock,
            "imagen" => $ruta,
            "estado" => $estado,
            "categoria" => $categoria,
        ];

        $consulta = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, estado, idCategoria) 
                     VALUES (:nombre, :descripcion, :precio, :stock, :imagen, :estado, :categoria)";

        try {
            $smts = $mysql->obtenerConexion()->prepare($consulta);
            $smts->execute($producto);
            header("Location: " . BASE_URL . "views/productos.php");
        } catch (PDOException $e) {
            $errores[] = "Error al insertar: " . $e->getMessage();
            echo "Aca esta el error";
        }

        $mysql->desconectar();
    }
} else {
    $errores["SinImagen"] = "No se ha subido ninguna imagen";
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/productos.php");
    exit();
}
?>
