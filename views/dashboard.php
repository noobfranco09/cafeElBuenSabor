<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <title>Coffee Dashboard</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="user-profile">
                <div class="profile-info">
                    <div class="profile-name">Juan Pérez</div>
                    <div class="profile-role">Administrador</div>
                </div>
                <div class="profile-avatar">JP</div>
            </div>
        </div>
    </header>

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
                        <a href="#" class="sidebar-link active">
                            <span class="sidebar-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">📈</span>
                            Estadísticas
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">👥</span>
                            Usuarios
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">🛍️</span>
                            Productos
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Gestión</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">⚙️</span>
                            Configuración
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">📋</span>
                            Reportes
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">💬</span>
                            Mensajes
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Cuenta</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">👤</span>
                            Perfil
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">🚪</span>
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Layout principal -->
    <div class="dashboard-layout">
        <main class="main-content">
            <!-- Tarjetas de estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">👥</div>
                    </div>
                    <div class="stat-value">2,345</div>
                    <div class="stat-label">Usuarios Activos</div>
                    <div class="stat-change positive">
                        ↗️ +12% vs mes anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">💰</div>
                    </div>
                    <div class="stat-value">$45,678</div>
                    <div class="stat-label">Ingresos Mensuales</div>
                    <div class="stat-change positive">
                        ↗️ +8% vs mes anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">📦</div>
                    </div>
                    <div class="stat-value">1,234</div>
                    <div class="stat-label">Pedidos</div>
                    <div class="stat-change negative">
                        ↘️ -3% vs mes anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">⭐</div>
                    </div>
                    <div class="stat-value">4.8</div>
                    <div class="stat-label">Satisfacción</div>
                    <div class="stat-change positive">
                        ↗️ +0.2 vs mes anterior
                    </div>
                </div>
            </div>

            <!-- Área de contenido principal -->
            <div class="content-area">
                <div class="content-header">
                    <h2 class="content-title">Área de Contenido Principal</h2>
                    <button class="action-button">
                        ➕ Nueva Acción
                    </button>
                </div>
                
                <div class="content-placeholder">
                    <div class="placeholder-icon">☕</div>
                    <div class="placeholder-text">Aquí va tu contenido personalizado</div>
                    <div class="placeholder-subtext">
                        Este espacio está listo para que agregues tus secciones específicas
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/dashboard.js"></script>

</body>
</html>