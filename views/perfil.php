<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}
$nombre = $_SESSION["nombre"]??"Desconocido";
$rol = $_SESSION["rol"]??"Desconocido";
$correo = $_SESSION["correo"]??"correo@ejemplo.com";
$telefono = $_SESSION["telefono"]??"";
$icono = str_split($nombre)??"?";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <title>Mi Perfil - CoffeeShop Pro</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <?php include './components/navbar.php'; ?>
    <?php 
        $activePage = 'perfil';
        include './components/sidebar.php'; 
    ?>
    <?php include './components/logoutModal.php'; ?>
    <div class="dashboard-layout">
        <main class="main-content">
            <div class="perfil-card-pro">
                <div class="perfil-header-pro">
                    <div class="perfil-header-bg"></div>
                    <div class="perfil-avatar-pro"><?php echo $icono[0] ?></div>
                    <div class="perfil-header-info">
                        <h2 class="perfil-title-pro">¡Hola, <?php echo htmlspecialchars($nombre) ?>!</h2>
                        <div class="perfil-rol-pro">Rol: <?php echo $rol ?></div>
                        <div class="perfil-welcome-pro">Administra tu información personal y mantén tu cuenta segura.</div>
                    </div>
                </div>
                <form class="perfil-form-pro">
                    <div class="perfil-form-block">
                        <div class="perfil-form-block-title">Datos personales</div>
                        <div class="perfil-form-group-pro">
                            <label for="nombre"><span class="perfil-input-icon">👤</span>Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre) ?>" autocomplete="off">
                        </div>
                        <div class="perfil-form-group-pro">
                            <label for="correo"><span class="perfil-input-icon">✉️</span>Correo</label>
                            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo) ?>" autocomplete="off">
                        </div>
                        <div class="perfil-form-group-pro">
                            <label for="telefono"><span class="perfil-input-icon">📞</span>Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono) ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="perfil-form-block perfil-form-block-contraseña">
                        <div class="perfil-form-block-title">Cambio de contraseña</div>
                        <div class="perfil-form-group-pro">
                            <label for="password-actual"><span class="perfil-input-icon">🔒</span>Contraseña actual</label>
                            <input type="password" id="password-actual" name="password_actual" placeholder="••••••••">
                        </div>
                        <div class="perfil-form-group-pro">
                            <label for="password-nueva"><span class="perfil-input-icon">🔑</span>Nueva contraseña</label>
                            <input type="password" id="password-nueva" name="password_nueva" placeholder="••••••••">
                        </div>
                        <div class="perfil-form-group-pro">
                            <label for="password-confirmar"><span class="perfil-input-icon">🔑</span>Confirmar nueva contraseña</label>
                            <input type="password" id="password-confirmar" name="password_confirmar" placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="perfil-btn-guardar-pro"><span class="perfil-btn-icon">💾</span> Guardar Cambios</button>
                </form>
            </div>
        </main>
    </div>
    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
</body>
</html> 