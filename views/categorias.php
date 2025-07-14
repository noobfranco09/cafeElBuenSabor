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

$obtenerCategorias = $conexion->query("SELECT * FROM categorias");

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
    <title>Categorías</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'categorias';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content">
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">📂</span>
                <div>
                  <h2>Gestión de Categorías</h2>
                  <p class="section-subtitle">Administra las categorías de productos del sistema</p>
                </div>
              </div>
            </div>
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="content-title">Categorías</h2>
                    <button class="action-button" style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#ModalAgregarCategoria">Agregar Categoría</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaCategorias" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre de la Categoría</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php while($mostrarCategorias = $obtenerCategorias->fetch(PDO::FETCH_ASSOC)) :   ?>

                          <tr>
                            <td><?php echo $mostrarCategorias["nombre"] ?></td>
                            <td><?php echo $mostrarCategorias["descripcion"] ?></td>
                            <td><?php echo $mostrarCategorias["estado"] ?></td>

                            <td>

                                <button type="button" class="btn btn-warning btn-sm btnEditar" 
                                data-bs-toggle="modal" data-bs-target="#ModalEditarCategoria" data-id="<?php echo $mostrarCategorias["idCategoria"]?>"
                                data-nombre="<?php echo $mostrarCategorias["nombre"]?>"
                                data-descripcion="<?php echo $mostrarCategorias["descripcion"]?>"
                                data-estado="<?php echo $mostrarCategorias["estado"]?>"><i class="bi bi-pencil-square "></i></button>

                                <?php if($mostrarCategorias["estado"]=="Activa"): ?>
                                <button type="button" class="btn btn-danger btn-sm btnDesactivar" data-id="<?php echo $mostrarCategorias["idCategoria"]?>"
                                data-nombre="<?php echo $mostrarCategorias["nombre"]?>"><i class="bi bi-trash "></i></button></a>
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

  <!-- Modal Agregar Categoría -->
  <div class="modal fade" id="ModalAgregarCategoria" tabindex="-1" aria-labelledby="ModalAgregarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalAgregarCategoriaLabel">Agregar Categoría</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../controller/agregarCategoria.php" method="POST" >
            <div class="mb-3">
              <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
              <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="Ingrese el nombre de la categoría" required>
            </div>
            <div class="mb-3">
              <label for="descripcionCategoria" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcionCategoria" name="descripcionCategoria" placeholder="Ingrese una descripción" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning">Agregar Categoría</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar Categoría -->
  <div class="modal fade" id="ModalEditarCategoria" tabindex="-1" aria-labelledby="ModalEditarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalEditarCategoriaLabel">Editar Categoría</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formEditarCategoria" action="../controller/editarCategoria.php" method="POST" >
            <input type="hidden" name="idCategoriaEditar" id="idCategoriaEditar">
            <div class="mb-3">
              <label for="nombreCategoriaEditar" class="form-label">Nombre de la Categoría</label>
              <input type="text" class="form-control" id="nombreCategoriaEditar" name="nombreCategoriaEditar" required>
            </div>
            <div class="mb-3">
              <label for="descripcionCategoriaEditar" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcionCategoriaEditar" name="descripcionCategoriaEditar" required>
            </div>
            <div class="mb-3">
              <label for="descripcionCategoriaEditar" class="form-label">Estado</label>
              <select name="estadoCategoriaEditar" id="estadoCategoriaEditar" class="form-control" required >
                <option value="">Seleccione un estado...</option>
                <option value="Activa">Activa</option>
                <option value="Inactiva">Inactiva</option>
              </select>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-warning" form="formEditarCategoria">Actualizar Categoría</button>
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
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/categorias.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaCategorias').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 