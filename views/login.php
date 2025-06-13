<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/login.css">
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
                    placeholder="Correo electrónico"
                    required
                    id="email"
                >
            </div>

            <div class="form-group">
                <input 
                    type="password" 
                    class="form-input"
                    name="contraseña"
                    placeholder="Contraseña"
                    required
                    id="password"
                >
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

    <script src="/assets/js/login.js"></script>

</body>
</html>