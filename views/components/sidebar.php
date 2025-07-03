<!-- Sidebar -->
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
                <li class="sidebar-item">
                    <a href="/views/dashboard.php" class="sidebar-link <?php echo ($activePage === 'dashboard') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-bar-chart-line"></i></span>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/views/empleados.php" class="sidebar-link <?php echo ($activePage === 'empleados') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-people"></i></span>
                        Empleados
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/views/productos.php" class="sidebar-link <?php echo ($activePage === 'productos') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-box-seam"></i></span>
                        Productos
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/views/generarQr.php" class="sidebar-link <?php echo ($activePage === 'generarQr') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-qr-code"></i></span>
                        Generar QR
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/views/pedidos.php" class="sidebar-link <?php echo ($activePage === 'pedidos') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-cart"></i></span>
                        Pedidos
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/views/ventas.php" class="sidebar-link <?php echo ($activePage === 'ventas') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-cash-coin"></i></span>
                        Ventas
                    </a>
                </li>
               
                <li class="sidebar-item">
                    <a href="/views/reportes.php" class="sidebar-link <?php echo ($activePage === 'reportes') ? 'active' : ''; ?>">
                        <span class="sidebar-icon"><i class="bi bi-clipboard-data"></i></span>
                        Reportes
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-section">
            <h3 class="sidebar-title">Cuenta</h3>
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="/views/perfil.php" class="sidebar-link <?php echo ($activePage === 'perfil') ? 'active' : ''; ?>">
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