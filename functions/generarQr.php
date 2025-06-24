<?php
require '.././libraries/phpqrcode/qrlib.php';
function generarQr ($idMesa) {
    $idMesa = $_POST['idMesa'];
    $codigo = 'carta' . uniqid();
    $url = "https://localhost:8080/cartaProductos.php";
    QRcode::png($url);
};


?>