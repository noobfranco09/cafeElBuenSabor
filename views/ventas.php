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
    <link rel="stylesheet" href="/assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <title>Ventas</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <?php include './components/navbar.php'; ?>
    <?php 
        $activePage = 'ventas';
        include './components/sidebar.php'; 
    ?>
    <?php include './components/logoutModal.php'; ?>
    <div class="dashboard-layout">
        <main class="main-content">
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">💵</span>
                <div>
                  <h2>Registro de Ventas</h2>
                  <p class="section-subtitle">Consulta y gestiona todas las ventas realizadas</p>
                </div>
              </div>
            </div>
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <h2 class="content-title">Registro de Ventas</h2>
                </div>
                <div class="charts-grid">
                    <div class="chart-container">
                        <div class="chart-header">
                            <span class="chart-title">Ingresos por Fecha</span>
                        </div>
                        <canvas id="chartIngresosFecha" height="120"></canvas>
                    </div>
                    <div class="chart-container">
                        <div class="chart-header">
                            <span class="chart-title">Ingresos por Empleado</span>
                        </div>
                        <canvas id="chartIngresosEmpleado" height="120"></canvas>
                    </div>
                    <div class="chart-container">
                        <div class="chart-header">
                            <span class="chart-title">Ingresos por Mesa</span>
                        </div>
                        <canvas id="ingresoPorMesa" height="100"></canvas>
                    </div>
                </div>
                <div class="ventas-table-card">
                    <div class="ventas-table-header">
                        <span class="ventas-table-title">Ventas Finalizadas</span>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <table id="tablaVentas" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Mesa</th>
                                    <th>Empleado</th>
                                    <th>Total</th>
                                    <th>Factura</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1001</td>
                                    <td>2024-06-19</td>
                                    <td>Mesa 1</td>
                                    <td>Juan Pérez</td>
                                    <td>$120.00</td>
                                    <td><button class="btn-pdf">PDF</button></td>
                                </tr>
                                <tr>
                                    <td>1002</td>
                                    <td>2024-06-19</td>
                                    <td>Mesa 2</td>
                                    <td>María López</td>
                                    <td>$85.50</td>
                                    <td><button class="btn-pdf">PDF</button></td>
                                </tr>
                                <tr>
                                    <td>1003</td>
                                    <td>2024-06-18</td>
                                    <td>Mesa 1</td>
                                    <td>Juan Pérez</td>
                                    <td>$60.00</td>
                                    <td><button class="btn-pdf">PDF</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="../libraries/Char.js/dist/chart.umd.min.js"></script>
    <script src="../assets/js/graficoIngresosPorMesas.js"></script>
</body>
</html> 