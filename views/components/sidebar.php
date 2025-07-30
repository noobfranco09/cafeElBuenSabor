<!-- Sidebar -->
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '<?php echo BASE_URL ?>/functions/rutas.php'; ?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="company-logo">
            <span class="company-icon">☕</span>
            <div class="company-info">
                <div class="company-name">CoffeeShop Pro</div>
                <div class="company-subtitle">Management System</div>
            </div>
        </a>
        <!-- Botón de cerrar sidebar en móvil -->
        <button class="close-sidebar-btn" onclick="closeSidebar()">
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="sidebar-content">
        <div class="sidebar-section">
            <h3 class="sidebar-title">Principal</h3>
            <ul class="sidebar-menu">

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/dashboard.php" class="sidebar-link <?php echo ($activePage === 'dashboard') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-bar-chart-line"></i></span>
                        Dashboard
                    </a>
                </li>
                <?php endif; ?>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/empleados.php" class="sidebar-link <?php echo ($activePage === 'empleados') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-people"></i></span>
                        Empleados
                    </a>
                </li>
                <?php endif; ?>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/mesas.php" class="sidebar-link <?php echo (
                        $activePage === 'mesas') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-table"></i></span>
                        Mesas
                    </a>
                </li>
                <?php endif; ?>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/rol.php" class="sidebar-link <?php echo (
                        $activePage === 'rol') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-shield-lock"></i></span>
                        Roles
                    </a>
                </li>
                <?php endif; ?>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/categorias.php" class="sidebar-link <?php echo ($activePage === 'categorias') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-folder"></i></span>
                        Categorías
                    </a>
                </li>
                <?php endif; ?>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/productos.php" class="sidebar-link <?php echo ($activePage === 'productos') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-box-seam"></i></span>
                        Productos
                    </a>
                </li>
                <?php endif; ?>

                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/generarQr.php" class="sidebar-link <?php echo ($activePage === 'generarQr') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-qr-code"></i></span>
                        Generar QR
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/pedidos.php" class="sidebar-link <?php echo ($activePage === 'pedidos') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-cart"></i></span>
                        Pedidos
                    </a>
                </li>

                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/ventas.php" class="sidebar-link <?php echo ($activePage === 'ventas') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-cash-coin"></i></span>
                        Ventas
                    </a>
                </li>
                <?php endif; ?>
               
                <?php if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "Admin"): ?>
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/reportes.php" class="sidebar-link <?php echo ($activePage === 'reportes') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-clipboard-data"></i></span>
                        Reportes
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="sidebar-section">
            <h3 class="sidebar-title">Cuenta</h3>
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="<?php echo BASE_URL ?>/views/perfil.php" class="sidebar-link <?php echo ($activePage === 'perfil') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-person"></i></span>
                        Perfil
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showLogoutModal()">
                        <span class="sidebar-icon"><i class="bi bi-box-arrow-right"></i></span>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside> 