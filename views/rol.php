<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}

$nombre = $_SESSION["nombre"]??"Desconocido";
$rol = $_SESSION["rol"]??"Desconocido";
$icono = str_split($nombre)??"?";

require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerRoles = $conexion->query("SELECT * FROM roles");

$mysql->desconectar();

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
    <title>Roles</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'rol';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content">
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">🛡️</span>
                <div>
                  <h2>Gestión de Roles</h2>
                  <p class="section-subtitle">Administra los roles y permisos del sistema</p>
                </div>
              </div>
            </div>
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="content-title">Roles</h2>
                    <button class="action-button" style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#ModalAgregarRol">Agregar Rol</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaRoles" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre del Rol</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php while($mostrarRoles = $obtenerRoles->fetch(PDO::FETCH_ASSOC)) :   ?>

                          <tr>
                            <td><?php echo $mostrarRoles["nombre"] ?></td>
                            <td><?php echo $mostrarRoles["descripcion"] ?></td>
                            <td><?php echo $mostrarRoles["estado"] ?></td>

                            <td>

                                <button type="button" class="btn btn-warning btn-sm btnEditar"><i class="bi bi-pencil-square "></i></button>
                                <?php if($mostrarRoles["estado"]=="SinVincular"): ?>
                                <button type="button" class="btn btn-danger btn-sm btnDesactivar"><i class="bi bi-trash "></i></button></a>
                                <?php endif; ?>    
                                      
                            </td>
                          </tr>

                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

  <!-- Modal Agregar Rol -->
  <div class="modal fade" id="ModalAgregarRol" tabindex="-1" aria-labelledby="ModalAgregarRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalAgregarRolLabel">Agregar Rol</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../controller/agregarRol.php" method="POST" >
            <div class="mb-3">
              <label for="nombreRol" class="form-label">Nombre del Rol</label>
              <input type="text" class="form-control" id="nombreRol" name="nombreRol" placeholder="Ingrese el nombre del rol" required>
            </div>
            <div class="mb-3">
              <label for="descripcionRol" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcionRol" name="descripcionRol" placeholder="Ingrese una descripción" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning">Agregar Rol</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Editar Rol -->
<div class="modal fade" id="mdlEditarRol" tabindex="-1" aria-labelledby="mdlEditarRolLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mdlEditarRolLabel">Editar Rol</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarRol" action="#" method="POST" >
          <input type="hidden" name="idRol" id="idRolEditar">
          <div class="mb-3">
            <label for="nombreRolEditar" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombreRolEditar" name="nombreRol" required>
          </div>
          <div class="mb-3">
            <label for="descripcionRolEditar" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcionRolEditar" name="descripcionRol" required>
          </div>
          <div class="mb-3">
            <label for="permisosRolEditar" class="form-label">Permisos</label>
            <input type="text" class="form-control" id="permisosRolEditar" name="permisosRol" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-warning" form="formEditarRol">Actualizar Rol</button>
          </div>
        </form>
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
            $('#tablaRoles').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 