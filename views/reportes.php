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
    <title>Reportes - CoffeeShop Pro</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <?php include './components/navbar.php'; ?>
    <?php 
        $activePage = 'reportes';
        include './components/sidebar.php'; 
    ?>
    <?php include './components/logoutModal.php'; ?>
    <div class="dashboard-layout">
        <main class="main-content">
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">📊</span>
                <div>
                  <h2>Reportes y Estadísticas</h2>
                  <p class="section-subtitle">Visualiza y descarga reportes clave para tu negocio</p>
                </div>
              </div>
            </div>
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <h2 class="content-title">Reportes y Estadísticas</h2>
                </div>
                <div class="reportes-grid">
                    <div class="reporte-card">
                        <div class="reporte-icon">📈</div>
                        <div class="reporte-title">Balance General de Ventas</div>
                        <div class="reporte-desc">Genera un PDF con el balance de ventas entre fechas.</div>
                        <button class="reporte-btn" data-bs-toggle="modal" data-bs-target="#ModalBalanceEntreFechas">Generar balance</button>
                    </div>
                    <div class="reporte-card">
                        <div class="reporte-icon">👤</div>
                        <div class="reporte-title">Reporte de Empleados</div>
                        <div class="reporte-desc">Descarga un PDF con el listado completo de empleados.</div>
                        <button class="reporte-btn"><a href="../controller/generarPDFDesempeñoEmpleado.php">Ver empleados</a></button>
                    </div>
                    <div class="reporte-card">
                        <div class="reporte-icon">📦</div>
                        <div class="reporte-title">Estado del Inventario</div>
                        <div class="reporte-desc">Descarga un PDF con el estado actual del inventario.</div>
                        <button class="reporte-btn"><a href="../controller/generarPDFEstadoInventario.php">Ver inventario</a></button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Agregar Rol -->
  <div class="modal fade" id="ModalBalanceEntreFechas" tabindex="-1" aria-labelledby="ModalBalanceEntreFechasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalBalanceEntreFechasLabel">Generar Balance Entre Fechas</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../controller/generarPDFBalanceGeneralVentas.php" method="POST" >
            <div class="mb-3">
              <label for="nombreRol" class="form-label">Fecha Inicial</label>
              <input type="date" class="form-control" name="fechaInicial" id="fechaInicial" required>
            </div>
            <div class="mb-3">
              <label for="descripcionRol" class="form-label">Fecha Final</label>
              <input type="date" class="form-control" name="fechaFinal" id="fechaFinal" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-warning">Generar PDF</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
</body>
</html> 