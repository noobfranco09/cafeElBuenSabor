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
            <div class="content-area">
                <div class="content-header" style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
                    <div class="perfil-avatar-big"><?php echo $icono[0] ?></div>
                    <div>
                        <h2 class="content-title" style="margin-bottom: 2px;">Mi Perfil</h2>
                        <div class="perfil-rol">Rol: <?php echo $rol ?></div>
                    </div>
                </div>
                <form class="perfil-form">
                    <div class="perfil-form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre) ?>" autocomplete="off">
                    </div>
                    <div class="perfil-form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo) ?>" autocomplete="off">
                    </div>
                    <div class="perfil-form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono) ?>" autocomplete="off">
                    </div>
                    <div class="perfil-form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••">
                    </div>
                    <button type="submit" class="perfil-btn-guardar">Guardar Cambios</button>
                </form>
            </div>
        </main>
    </div>
    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
</body>
</html> 