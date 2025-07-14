<?php
session_start();

$errores = $_SESSION["errores"]??[];
$old = $_SESSION["old"]??[];

unset($_SESSION["old"],$_SESSION["errores"]);
if(isset($_SESSION["id"])){
    header("location:./dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/login.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/bootstrap-icons/bootstrap-icons.css">
    <title>Coffee Login</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="coffee-circle circle-4"></div>
    <div class="coffee-circle circle-5"></div>
    <div class="coffee-circle circle-6"></div>

    <!-- Contenedor principal -->
    <div class="login-container">
        <div class="login-header">
            <div class="coffee-icon">☕</div>
            <h1 class="login-title">Cafe & Bebidas El Buen Sabor</h1>
            <p class="login-subtitle">Inicia sesión para continuar</p>
        </div>

        <form class="login-form" method="POST" action="../controller/admin/login.php">
            <div class="form-group">

                <input 
                    type="email" 
                    class="form-input"
                    name="correo"
                    <?php if(isset($old["correo"]) && !empty($old["correo"])):  ?>
                    value="<?php echo $old["correo"]; ?>"
                    <?php endif;  ?>
                    placeholder="Correo electrónico"
                    required
                    id="email"
                >
               
                <?php if(isset($errores["errorCorreo"]) && !empty($errores["errorCorreo"])):  ?>
                    <p class="text-start text-danger"><?php echo $errores["errorCorreo"]; ?></p>
                    <?php endif;  ?>
                    <?php if(isset($errores["correoNoExiste"]) && !empty($errores["correoNoExiste"])):  ?>
                    <p class="text-start text-danger"><?php echo $errores["correoNoExiste"]; ?></p>
                    <?php endif;  ?>
            </div>
             <!-- Aca se puede ver el error del correo -->
            

            <div class="form-group">
                <input 
                    type="password" 
                    class="form-input"
                    name="contraseña"
                    <?php if(isset($old["contraseña"]) && !empty($old["contraseña"])):  ?>
                    value="<?php echo htmlspecialchars($old["contraseña"]); ?>"
                    <?php endif;  ?>
                    placeholder="Contraseña"
                    required
                    id="password"
                >
                <?php if(isset($errores["contraseñaIncorrecta"]) && !empty($errores["contraseñaIncorrecta"])):  ?>
                    <p class="text-start text-danger"><?php echo $errores["contraseñaIncorrecta"]; ?></p>
                    <?php endif;  ?>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    🙈
                </button>
            </div>

            <button type="submit" class="login-btn">
                Iniciar Sesión
            </button>
        </form>

        <div class="login-links">
            <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>

    <script src="/cafeElBuenSabor/assets/js/login.js"></script>

</body>
</html>