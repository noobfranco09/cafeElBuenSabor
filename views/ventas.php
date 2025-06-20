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
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <h2 class="content-title">Registro de Ventas</h2>
                </div>
                <div class="filters-row">
                    <div>
                        <label for="fechaFiltro">Fecha:</label>
                        <input type="date" id="fechaFiltro" name="fechaFiltro">
                    </div>
                    <div>
                        <label for="empleadoFiltro">Empleado:</label>
                        <select id="empleadoFiltro" name="empleadoFiltro">
                            <option value="">Todos</option>
                            <option value="1">Juan Pérez</option>
                            <option value="2">María López</option>
                        </select>
                    </div>
                    <div>
                        <label for="mesaFiltro">Mesa:</label>
                        <select id="mesaFiltro" name="mesaFiltro">
                            <option value="">Todas</option>
                            <option value="1">Mesa 1</option>
                            <option value="2">Mesa 2</option>
                        </select>
                    </div>
                </div>
                <div class="stats-grid" style="margin-bottom: 20px;">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">💵</div>
                        </div>
                        <div class="stat-value">$265.50</div>
                        <div class="stat-label">Ingresos del Día</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">👤</div>
                        </div>
                        <div class="stat-value">$205.50</div>
                        <div class="stat-label">Ingresos por Empleado</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">🍽️</div>
                        </div>
                        <div class="stat-value">$120.00</div>
                        <div class="stat-label">Ingresos por Mesa</div>
                    </div>
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
                                <td><button class="btn-pdf" onclick="alert('Generar PDF de factura 1001')">PDF</button></td>
                            </tr>
                            <tr>
                                <td>1002</td>
                                <td>2024-06-19</td>
                                <td>Mesa 2</td>
                                <td>María López</td>
                                <td>$85.50</td>
                                <td><button class="btn-pdf" onclick="alert('Generar PDF de factura 1002')">PDF</button></td>
                            </tr>
                            <tr>
                                <td>1003</td>
                                <td>2024-06-18</td>
                                <td>Mesa 1</td>
                                <td>Juan Pérez</td>
                                <td>$60.00</td>
                                <td><button class="btn-pdf" onclick="alert('Generar PDF de factura 1003')">PDF</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaVentas').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 