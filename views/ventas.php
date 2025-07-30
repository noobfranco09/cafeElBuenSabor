<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeelbuensabor/functions/rutas.php';
session_start();

if (!isset($_SESSION["id"])){  
    header("Location:" . BASE_URL . 'views/login.php');
    exit();
}
if ($_SESSION["estado"] == "Inactivo"){
    header("Location:" . BASE_URL . 'views/login.php');
    exit();
}
$nombre = $_SESSION["nombre"] ?? "Desconocido";
$rol = $_SESSION["rol"] ?? "Desconocido";
$icono = str_split($nombre) ?? "?";

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerVentas = $conexion->query("SELECT ventas.idVenta, ventas.fecha, ventas.total, mesas.numero, usuario.nombre FROM ventas
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN mesas ON mesas.idMesa = pedidos.idMesa
JOIN usuario ON usuario.idUsuario = pedidos.idUsuario");

$mysql->desconectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <title>Ventas</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <?php include BASE_PATH . 'views/components/navbar.php'; ?>
    <?php 
        $activePage = 'ventas';
        include BASE_PATH . 'views/components/sidebar.php'; 
    ?>
    <?php include BASE_PATH . 'views/components/logoutModal.php'; ?>
    
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
                        <canvas id="ingresoPorFecha" width="600" height="400"></canvas>
                    </div>
                    <div class="chart-container">
                        <div class="chart-header">
                            <span class="chart-title">Ingresos por Empleado</span>
                        </div>
                        <canvas id="ingresoPorEmpleado" width="600" height="400"></canvas>
                    </div>
                    <div class="chart-container">
                        <div class="chart-header">
                            <span class="chart-title">Ingresos por Mesa</span>
                        </div>
                        <div class="chart-body">
                            <canvas id="ingresoPorMesa"></canvas>
                        </div>
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
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($mostrarVentas = $obtenerVentas->fetch(PDO::FETCH_ASSOC)) : ?>
                                <tr>
                                    <td><?php echo $mostrarVentas["idVenta"]; ?></td>
                                    <td><?php echo $mostrarVentas["fecha"]; ?></td>
                                    <td><?php echo $mostrarVentas["numero"]; ?></td>
                                    <td><?php echo $mostrarVentas["nombre"]; ?></td>
                                    <td>$<?php echo number_format($mostrarVentas['total'], 0, ',', '.'); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btnVista" data-id="<?php echo $mostrarVentas["idVenta"] ?>" data-bs-toggle="modal" data-bs-target="#ModalVistaPedido"><i class="bi bi-eye-fill"></i></button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Vista de Pedido -->
    <div class="modal fade" id="ModalVistaPedido" tabindex="-1" aria-labelledby="ModalVistaPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalVistaPedidoLabel">Información de la Venta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-lingth">
                            <thead>
                                <tr>
                                    <th scope="col">ID Pedido</th>
                                    <th scope="col">Mesa</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Nota</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody id="informacionPedido">
                                <!-- Aquí se insertará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL ?>libraries/Char.js/dist/chart.umd.min.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/dashboard.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/graficoIngresosPorMesas.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/graficoIngresosPorFecha.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/graficoIngresoPorEmpleado.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/vistaVentaConPedido.js"></script>
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
