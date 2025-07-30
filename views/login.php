<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeelbuensabor/functions/rutas.php';
session_start();

// Incluye las constantes de rutas antes de usar
// include 'ruta/a/tu/archivo/rutas.php'; 
// (Asegúrate de incluir el archivo donde defines BASE_URL y BASE_PATH)

$errores = $_SESSION["errores"] ?? [];
$old = $_SESSION["old"] ?? [];

unset($_SESSION["old"], $_SESSION["errores"]);

if (isset($_SESSION["id"])) {
    header("Location: ./dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/boostrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap-icons/bootstrap-icons.css" />
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

        <form class="login-form" method="POST" action="<?= BASE_URL ?>controller/admin/login.php">
            <div class="form-group">

                <input
                    type="email"
                    class="form-input"
                    name="correo"
                    placeholder="Correo electrónico"
                    required
                    id="email"
                    value="<?= isset($old["correo"]) ? htmlspecialchars($old["correo"], ENT_QUOTES, 'UTF-8') : '' ?>"
                />
               
                <?php if (!empty($errores["errorCorreo"])): ?>
                    <p class="text-start text-danger"><?= htmlspecialchars($errores["errorCorreo"]) ?></p>
                <?php endif; ?>

                <?php if (!empty($errores["correoNoExiste"])): ?>
                    <p class="text-start text-danger"><?= htmlspecialchars($errores["correoNoExiste"]) ?></p>
                <?php endif; ?>

                <?php if (!empty($errores["usuarioInactivo"])): ?>
                    <p class="text-start text-danger"><?= htmlspecialchars($errores["usuarioInactivo"]) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input
                    type="password"
                    class="form-input"
                    name="contraseña"
                    placeholder="Contraseña"
                    required
                    id="password"
                />
                <?php if (!empty($errores["contraseñaIncorrecta"])): ?>
                    <p class="text-start text-danger"><?= htmlspecialchars($errores["contraseñaIncorrecta"]) ?></p>
                <?php endif; ?>
                <button type="button" class="password-toggle" onclick="togglePassword()">🙈</button>
            </div>

            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>

        <div class="login-links">
            <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/js/login.js"></script>
</body>
</html>
