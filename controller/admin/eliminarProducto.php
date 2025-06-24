<?php
require '../../models/mySql.php';

$idProducto=$_POST['idProducto'];
$db=new MySQL();
$db->conectar();
$conexion=$db->obtenerConexion() ;

$consulta=$conexion->prepare('update producto set estado = 0 where idProducto = :idProducto');
$consulta->execute(['idProducto'=>$idProducto]);

$db->desconectar();
?>