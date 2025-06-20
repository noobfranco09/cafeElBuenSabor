<?php   
session_start();
session_destroy();
session_unset();

echo json_encode([
    "estado"=>"ok",
    "redirecion"=>"../../views/login.php"
])

?>