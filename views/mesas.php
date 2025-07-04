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
    <link rel="stylesheet" href="/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap-icons/bootstrap-icons.css">
    <title>Mesas</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'mesas';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content">
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">🍽️</span>
                <div>
                  <h2>Gestión de Mesas</h2>
                  <p class="section-subtitle">Administra la información y el estado de las mesas</p>
                </div>
              </div>
            </div>
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="content-title">Mesas</h2>
                    <button class="action-button" style="margin-bottom: 10px;" id="btnAgregarMesa">Agregar Mesa</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaMesas" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Capacidad</th>
                                <th>Ubicación</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMesasBody">
                            <!-- Aquí se llenarán las mesas dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
<!-- Modal Agregar Mesa -->
<div class="modal fade" id="mdlAgregarMesa" tabindex="-1" aria-labelledby="mdlAgregarMesaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mdlAgregarMesaLabel">Agregar Mesa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAgregarMesa" action="#" method="POST" >
          <div class="mb-3">
            <label for="numeroMesa" class="form-label">Número de Mesa</label>
            <input type="number" class="form-control" id="numeroMesa" name="numeroMesa" placeholder="Ingrese el número de mesa" required>
          </div>
          <div class="mb-3">
            <label for="capacidadMesa" class="form-label">Capacidad</label>
            <input type="number" class="form-control" id="capacidadMesa" name="capacidadMesa" placeholder="Ingrese la capacidad" required>
          </div>
          <div class="mb-3">
            <label for="ubicacionMesa" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="ubicacionMesa" name="ubicacionMesa" placeholder="Ingrese la ubicación" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning" form="formAgregarMesa">Agregar Mesa</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Mesa -->
<div class="modal fade" id="mdlEditarMesa" tabindex="-1" aria-labelledby="mdlEditarMesaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mdlEditarMesaLabel">Editar Mesa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarMesa" action="#" method="POST" >
          <input type="hidden" name="idMesa" id="idMesaEditar">
          <div class="mb-3">
            <label for="numeroMesaEditar" class="form-label">Número de Mesa</label>
            <input type="number" class="form-control" id="numeroMesaEditar" name="numeroMesa" required>
          </div>
          <div class="mb-3">
            <label for="capacidadMesaEditar" class="form-label">Capacidad</label>
            <input type="number" class="form-control" id="capacidadMesaEditar" name="capacidadMesa" required>
          </div>
          <div class="mb-3">
            <label for="ubicacionMesaEditar" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="ubicacionMesaEditar" name="ubicacionMesa" required>
          </div>
          <div class="mb-3">
            <label for="estadoMesaEditar" class="form-label">Estado</label>
            <select class="form-select" id="estadoMesaEditar" name="estadoMesa" required>
              <option value="Disponible">Disponible</option>
              <option value="Ocupada">Ocupada</option>
              <option value="Reservada">Reservada</option>
              <option value="Inactiva">Inactiva</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning" form="formEditarMesa">Actualizar Mesa</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaMesas').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 