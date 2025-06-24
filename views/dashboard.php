<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
    }

    $nombre = $_SESSION["nombre"]??"Desconocido";
    $rol = $_SESSION["rol"]??"Desconocido";
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
    <title>Coffee Dashboard</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'dashboard';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

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
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>

</body>
</html>