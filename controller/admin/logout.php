<?php
session_start();
session_destroy();
session_unset();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';

echo json_encode([
    "estado" => "ok",
    "redirecion" => BASE_URL . 'views/login.php'
]);
?>
