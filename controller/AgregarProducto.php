<?php

include '../functions/Validaciones.php';
session_start();

$validaciones = new Validaciones($_POST);

$errores = $validaciones->validarProducto();

if(!empty($errores)){
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../views/productos.php");
    exit();
}

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();

$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];
$categoria = $_POST["categoria"];
$estado = $_POST["estado"];
$descripcion = $_POST["descripcion"];

if($_FILES['imagen'] && $_FILES['imagen']['error'] === UPLOAD_ERR_OK)
{
    $imagnesPermitidas = ['image/jpg' => '.jpg', 'image/png' => '.png', 'image/jpeg' => '.jpeg'];
    $tipoImagen = mime_content_type($_FILES['imagen']['tmp_name']);

    if(!array_key_exists($tipoImagen,$imagnesPermitidas))
    {
        $errores["imagenNoPermitida"] = "Solo se permiten imágenes JPEG,JPG Y PNG.";
        $_SESSION["errores"]=$errores;
        $_SESSION["old"]=$_POST;
        header("location: ../views/productos.php");
        exit();
    }
                
    $img = $imagnesPermitidas[$tipoImagen];
    $nombreImagen = 'imagen_'.date('Ymd_Hisv').$img;
    $ruta = 'assets/imgProductos/'.$nombreImagen;
    $rutaAbsoluta = __DIR__.'/../'.$ruta;

    if(move_uploaded_file($_FILES['imagen']['tmp_name'],$rutaAbsoluta))
    {
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

        header("location: ../views/productos.php");
                    
        } catch (PDOException $e) {
                    
        $errores[] = "Error al insertar: ". $e->getMessage();
        echo "Aca esta el error";

        }

        $mysql->desconectar();
                

    }
} else {
            
    $errores["SinImagen"] = "No se ha subido ninguna imagen";
    $_SESSION["errores"]=$errores;
    $_SESSION["old"]=$_POST;
    header("location: ../views/productos.php");
    exit();

}



?>