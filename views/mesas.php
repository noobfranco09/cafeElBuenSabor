<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}
if ($_SESSION["estado"]=="Inactivo"){
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

$obtenerMesas = $conexion->query("SELECT * FROM mesas");

$mysql->desconectar();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/bootstrap-icons/bootstrap-icons.css">
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
                    <button class="action-button" style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#ModalAgregarMesa">Agregar Mesa</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaMesas" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                          <?php while($mostrarMesas = $obtenerMesas->fetch(PDO::FETCH_ASSOC)) :   ?>

                          <tr>
                            <td><?php echo $mostrarMesas["numero"] ?></td>
                            <td><?php echo $mostrarMesas["estado"] ?></td>

                            <td>

                                <button type="button" class="btn btn-warning btn-sm btnEditar" 
                                data-bs-toggle="modal" data-bs-target="#ModalEditarMesa" data-id="<?php echo $mostrarMesas["idMesa"]?>"
                                data-numero="<?php echo $mostrarMesas["numero"]?>"
                                data-estado="<?php echo $mostrarMesas["estado"]?>"><i class="bi bi-pencil-square "></i></button>

                                <button type="button" class="btn btn-danger btn-sm btnDesactivar" data-id="<?php echo $mostrarMesas["idMesa"]?> " 
                                data-numero="<?php echo $mostrarMesas["numero"]?>"><i class="bi bi-trash "></i></button></a>
                                      
                            </td>
                          </tr>

                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

  <!-- Modal Agregar Mesa -->
  <div class="modal fade" id="ModalAgregarMesa" tabindex="-1" aria-labelledby="ModalAgregarMesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalAgregarMesaLabel">Agregar Mesa</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../controller/agregarMesa.php" method="POST">
            <div class="mb-3">
              <label for="numeroMesa" class="form-label">Número de Mesa</label>
              <input type="number" class="form-control" id="numeroMesa" name="numeroMesa" placeholder="Ingrese el número de mesa" required>
            </div>
            <div class="mb-3">
              <label for="capacidadMesa" class="form-label">Estado</label>
              <select name="estadoMesa" id="estadoMesa" class="form-control" required>
                <option value="">Seleccione un estado...</option>
                <option value="Activa">Activa</option>
                <option value="Inactiva">Inactiva</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning">Agregar Mesa</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar Mesa -->
  <div class="modal fade" id="ModalEditarMesa" tabindex="-1" aria-labelledby="ModalEditarMesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalEditarMesaLabel">Editar Mesa</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../controller/editarMesa.php" method="POST" >
            <input type="hidden" name="idMesaEditar" id="idMesaEditar">
            <div class="mb-3">
              <label for="numeroMesaEditar" class="form-label">Número de Mesa</label>
              <input type="number" class="form-control" id="numeroMesaEditar" name="numeroMesaEditar" required>
            </div>
            <div class="mb-3">
              <label for="estadoMesaEditar" class="form-label">Estado</label>
              <select class="form-select" id="estadoMesaEditar" name="estadoMesaEditar" required>
                <option value="">Seleccione un estado...</option>
                <option value="Activa">Activa</option>
                <option value="Inactiva">Inactiva</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning">Actualizar Mesa</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/cafeElBuenSabor/assets/js/dashboard.js"></script>
    <script src="../assets/js/mesas.js"></script>
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