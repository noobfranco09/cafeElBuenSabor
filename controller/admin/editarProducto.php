<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH . 'functions/funcionSanitizar.php';
require_once BASE_PATH . 'models/mySql.php';



$db = new MySQL();
$db->conectar();
$conexion = $db->obtenerConexion();

if (isset($_FILES['editarImagen']) && $_FILES['editarImagen']['error'] === 0) {
    $nombreImagen = basename($_FILES['editarImagen']['name']);
    $rutaTemporal = $_FILES['editarImagen']['tmp_name'];
    $rutaDestino = "../../assets/images/" . $nombreImagen;
    $rutaSrc="../assets/images/".$nombreImagen;

    // Movemos la imagen a su destino
    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
    } else {
        echo "Error al guardar la imagen.";
        exit;
    }
} else {
    echo "Error al recibir la imagen.";
    exit;
}



$idProducto = $_POST['editarIdProducto'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$idCategoria = $_POST['idCategoria'];
$imagen = $_FILES['editarImagen'];

$datosSinSanitizar = [
    "nombre" => $nombre,
    "descripcion" => $descripcion,
    "precio" => $precio,
    "stock" => $stock,
    "idCategoria" => $idCategoria
];

$datosSanitizados = verificarVariables($datosSinSanitizar);
if ($datosSanitizados != false) {
    try {
        $datosSanitizados['idProducto'] = $idProducto;
        $datosSanitizados['imagen'] = $rutaSrc;
        $consulta = $conexion->prepare("update productos set nombre = :nombre,descripcion = :descripcion,precio = :precio,
    stock= :stock,idCategoria= :idCategoria,imagen= :imagen where idProducto = :idProducto");
        $consulta->execute($datosSanitizados);
        header('Location: /cafeElBuenSabor/views/productos.php');
        // echo "Editado exitosamente";
        exit;
    } catch (PDOException $e) {
        echo $e;
    }


} else {
    echo "¡Error! Por favor, llene los campos correctamente.";
}
$db->desconectar();
?>