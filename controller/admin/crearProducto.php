<?php 
require "../../functions/funcionSanitizar.php";
require "../../models/mySql.php";

$db=new MySQL();
$db->conectar();
$conexion=$db->obtenerConexion();


$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];
$stock=$_POST['stock'];
$estado=$_POST['estado'];
$idCategoria=$_POST['idCategoria'];

$datosSinSanitizar=[
    "nombre"=>$nombre,
    "descripcion"=>$descripcion,
    "precio"=>$precio,
    "stock"=>$stock,
    "estado"=>$estado,
    "idCategoria"=>$idCategoria
];

$datosSanitizados=verificarVariables($datosSinSanitizar);
if($datosSanitizados!= false)
{
    $consulta=$conexion->prepare("insert into productos (nombre,descripcion,precio,stock,estado,idCategoria) 
    values (:nombre,:descripcion,:precio,:stock,:estado,:idCategoria)");
    $consulta->execute($datosSanitizados);

}else
{
    echo "¡Error! Por favor, llene los campos correctamente.";
}
?>