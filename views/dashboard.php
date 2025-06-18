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
                <div class="profile-dropdown" onclick="toggleProfileMenu(event)">
                    <div class="profile-info">
                        <div class="profile-name">Juan Pérez</div>
                        <div class="profile-role">Administrador</div>
                    </div>
                    <div class="profile-avatar">JP</div>
                    <div class="dropdown-arrow">▼</div>
                </div>
                <div class="profile-menu" id="profileMenu">
                    <div class="menu-item" onclick="goToProfile()">
                        <span class="menu-icon">👤</span>
                        <span class="menu-text">Mi Perfil</span>
                    </div>
                    <div class="menu-divider"></div>
                    <div class="menu-item logout-item" onclick="showLogoutModal()">
                        <span class="menu-icon">🚪</span>
                        <span class="menu-text">Cerrar Sesión</span>
                    </div>
                </div>
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
                        <a href="/views/dashboard.php" class="sidebar-link active">
                            <span class="sidebar-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/inventario.php" class="sidebar-link">
                            <span class="sidebar-icon">📦</span>
                            Inventario
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/pedidos.php" class="sidebar-link">
                            <span class="sidebar-icon">🛒</span>
                            Pedidos
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/ventas.php" class="sidebar-link">
                            <span class="sidebar-icon">💰</span>
                            Ventas
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">📋</span>
                            Reportes
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
                        <a href="#" class="sidebar-link" onclick="showLogoutModal()">
                            <span class="sidebar-icon">🚪</span>
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Modal de confirmación de cierre de sesión -->
    <div class="logout-modal" id="logoutModal">
        <div class="modal-overlay" onclick="closeLogoutModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">🚪</div>
                <h3 class="modal-title">Cerrar Sesión</h3>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres cerrar sesión?</p>
                <p class="modal-subtitle">Se cerrará tu sesión actual y tendrás que volver a iniciar sesión.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel-btn" onclick="closeLogoutModal()">
                    Cancelar
                </button>
                <button class="modal-btn confirm-btn" onclick="confirmLogout()">
                    Sí, Cerrar Sesión
                </button>
            </div>
        </div>
    </div>

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
                    <h2 class="content-title">Análisis de Negocio</h2>
                </div>
                
                <!-- Grid de gráficos -->
                <div class="charts-grid">
                    <!-- Gráfico de Recaudo Mensual -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Recaudo Mensual</h3>
                            <div class="chart-actions">
                                <select class="chart-period">
                                    <option value="6m">Últimos 6 meses</option>
                                    <option value="1y">Último año</option>
                                    <option value="2y">Últimos 2 años</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" id="monthlyRevenueChart">
                            <!-- Aquí irá el gráfico de recaudo mensual -->
                        </div>
                    </div>

                    <!-- Gráfico de Productos Más Vendidos -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Productos Más Vendidos</h3>
                            <div class="chart-actions">
                                <select class="chart-period">
                                    <option value="week">Esta semana</option>
                                    <option value="month">Este mes</option>
                                    <option value="year">Este año</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" id="topProductsChart">
                            <!-- Aquí irá el gráfico de productos más vendidos -->
                        </div>
                    </div>

                    <!-- Gráfico de Ingresos por Empleado -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Ingresos por Empleado</h3>
                            <div class="chart-actions">
                                <select class="chart-period">
                                    <option value="today">Hoy</option>
                                    <option value="week">Esta semana</option>
                                    <option value="month">Este mes</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" id="employeeRevenueChart">
                            <!-- Aquí irá el gráfico de ingresos por empleado -->
                        </div>
                    </div>

                    <!-- Gráfico de Mesas Atendidas -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Mesas Atendidas por Mesero</h3>
                            <div class="chart-actions">
                                <select class="chart-period">
                                    <option value="today">Hoy</option>
                                    <option value="week">Esta semana</option>
                                    <option value="month">Este mes</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" id="tablesServedChart">
                            <!-- Aquí irá el gráfico de mesas atendidas -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Agregar Chart.js para las visualizaciones -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/dashboard.js"></script>

</body>
</html>