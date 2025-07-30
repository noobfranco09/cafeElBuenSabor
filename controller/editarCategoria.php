<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/Validaciones.php';

session_start();

$validaciones = new Validaciones($_POST);
$errores = $validaciones->validarCategoriaEditar();

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/categorias.php");
    exit();
}

require_once BASE_PATH . 'models/mySql.php';

$idCategoria = $_POST["idCategoriaEditar"];
$nombreCategoriaEditar = $_POST["nombreCategoriaEditar"];
$descripcionCategoriaEditar = $_POST["descripcionCategoriaEditar"];
$estadoCategoriaEditar = $_POST["estadoCategoriaEditar"];

$categoria = [
    "idCategoria" => $idCategoria,
    "nombre" => $nombreCategoriaEditar,
    "descripcion" => $descripcionCategoriaEditar,
    "estado" => $estadoCategoriaEditar
];

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$consulta = "UPDATE categorias 
             SET nombre = :nombre, descripcion = :descripcion, estado = :estado 
             WHERE idCategoria = :idCategoria";

try {
    $stmt = $conexion->prepare($consulta);
    $stmt->execute($categoria);

    if ($stmt->rowCount() > 0) {
        $_SESSION["mensaje"] = "Categoría actualizada correctamente.";
    } else {
        $_SESSION["mensaje"] = "No se realizaron cambios.";
    }

    header("Location: " . BASE_URL . "views/categorias.php");
} catch (PDOException $e) {
    $_SESSION["errores"][] = "Error al actualizar la categoría: " . $e->getMessage();
    $_SESSION["old"] = $_POST;
    header("Location: " . BASE_URL . "views/categorias.php");
    exit();
}
