<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeelbuensabor/functions/rutas.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

if ($_SESSION["estado"] == "Inactivo") {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

$nombre = $_SESSION["nombre"] ?? "Desconocido";
$rol = $_SESSION["rol"] ?? "Desconocido";
$icono = str_split($nombre) ?? "?";

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$cantidadUsuarios = $conexion->query("SELECT count(*) As contarUsuarios FROM usuario WHERE estado = 'Activo'");
$cantidadUsuario = $cantidadUsuarios->fetch(PDO::FETCH_ASSOC);

$mysql->desconectar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/boostrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dashboard.css" />
    <title>Coffee Dashboard</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <?php include BASE_PATH . 'components/navbar.php'; ?>

    <?php 
        $activePage = 'dashboard';
        include BASE_PATH . 'components/sidebar.php'; 
    ?>

    <?php include BASE_PATH . 'components/logoutModal.php'; ?>

    <!-- Layout principal -->
    <div class="dashboard-layout">
        <main class="main-content">
            <!-- Tarjetas de estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">👥</div>
                    </div>
                    <div class="stat-value"><?php echo $cantidadUsuario['contarUsuarios'] ?></div>
                    <div class="stat-label">Usuarios Activos</div>
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
                        </div>
                        <div class="chart-body" id="monthlyRevenueChart">
                            <!-- Aquí irá el gráfico de recaudo mensual -->
                            <canvas id="recaudoMensual" width="600" height="400"></canvas>
                        </div>
                    </div>

                    <!-- Gráfico de Productos Más Vendidos -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Productos Más Vendidos</h3>
                        </div>
                        <div class="chart-body">
                            <!-- Aquí irá el gráfico de productos más vendidos -->
                            <canvas id="productoMasVendido" width="600" height="400"></canvas>
                        </div>
                    </div>

                    <!-- Gráfico de Mesas Atendidas -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <h3 class="chart-title">Mesas Atendidas por Mesero</h3>
                        </div>
                        <div class="chart-body" id="tablesServedChart">
                            <!-- Aquí irá el gráfico de mesas atendidas -->
                            <canvas id="mesasPorMesero" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Agregar Chart.js para las visualizaciones -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/dashboard.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>libraries/Char.js/dist/chart.umd.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/graficoProductoMasVendido.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/graficoMesasPorMesero.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/graficoRecaudoMensual.js"></script>

</body>
</html>
