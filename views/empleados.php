<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}

$nombre = $_SESSION["nombre"]??"Desconocido";
$rol = $_SESSION["rol"]??"Desconocido";
$icono = str_split($nombre)??"?";


$errores = $_SESSION["errores"]??[];
$old = $_SESSION["old"]??[];
unset($_SESSION["errores"],$_SESSION["old"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/boostrap/bootstrap.min.css">
    <title>Empleados</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'empleados';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content">
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="content-title">Empleados</h2>
                    <button class="action-button" style="margin-bottom: 10px;" id="btnAgregar">Agregar Empleado</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaEmpleados" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha Ingreso</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

<div class="modal fade" id="mdlAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <form id="formAgregar" action="../controller/agregarEmpleado.php" method="POST" >
       
    <?php if(!empty($errores["datosVacios"]) && isset($errores["datosVacios"])): ?>
        <p class="text-start text-danger"><?php echo $errores["datosVacios"] ?></p>
    <?php endif; ?>


    <!-- Nombre -->
    <div class="mb-3">
         <?php if(!empty($errores["errorNombre"]) && isset($errores["errorNombre"])): ?>
            <p class="text-start text-danger"><?php echo $errores["errorNombre"] ?></p>
        <?php endif; ?>
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" 
        <?php if(isset($old["nombre"]) && !empty($old["nombre"])): ?>
            value="<?php echo $old["nombre"] ?>"
        <?php endif; ?>
        required>
    </div>


      <!-- Fecha Ingreso -->
    <div class="mb-3">
        <?php if(!empty($errores["errorFecha"]) && isset($errores["errorFecha"])): ?>
            <p class="text-start text-danger"><?php echo $errores["errorFecha"] ?></p>
        <?php endif; ?>
        <label for="fecha" class="form-label">Fecha Ingreso</label>
        <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Ingrese la fecha"
        <?php if(isset($old["fecha"]) && !empty($old["fecha"])): ?>
            value="<?php echo $old["fecha"] ?>"
        <?php endif; ?>
        required>
    </div>


     <!-- Telefono -->
    <div class="mb-3">
        <?php if(!empty($errores["errorTelefono"]) && isset($errores["errorTelefono"])): ?>
            <p class="text-start text-danger"><?php echo $errores["errorTelefono"] ?></p>
        <?php endif; ?>
        <label for="telefono" class="form-label">Telefono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el telefono"
        <?php if(isset($old["telefono"]) && !empty($old["telefono"])): ?>
            value="<?php echo $old["telefono"] ?>"
        <?php endif; ?>
        required>
    </div>


     <!-- Correo -->
    <div class="mb-3">
        <?php if(!empty($errores["errorCorreo"]) && isset($errores["errorCorreo"])): ?>
            <p class="text-start text-danger"><?php echo $errores["errorCorreo"] ?></p>
        <?php endif; ?>
        <?php if(!empty($errores["correoEnUso"]) && isset($errores["correoEnUso"])): ?>
            <p class="text-start text-danger"><?php echo $errores["correoEnUso"] ?></p>
        <?php endif; ?>
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo"
        <?php if(isset($old["correo"]) && !empty($old["correo"])): ?>
            value="<?php echo $old["correo"] ?>"
        <?php endif; ?>
        required>
    </div>


      <!-- Rol -->
    <div class="mb-3">
        <?php if(!empty($errores["errorRol"]) && isset($errores["errorRol"])): ?>
            <p class="text-start text-danger"><?php echo $errores["errorRol"] ?></p>
        <?php endif; ?>
        <label for="rol"  class="form-label">Rol</label>
        <input type="text" class="form-control" id="rol" name="rol" placeholder="Ingrese el rol"
        <?php if(isset($old["rol"]) && !empty($old["rol"])): ?>
            value="<?php echo $old["rol"] ?>"
        <?php endif; ?>
        required>
    </div>

     <!-- Contraseña -->
    <div class="mb-3">
        <label for="Contraseña"  class="form-label">Contraseña</label>
        <input type="text" class="form-control" id="Contraseña" name="contraseña" placeholder="Ingrese la Contraseña "
        <?php if(isset($old["contraseña"]) && !empty($old["contraseña"])): ?>
            value="<?php echo $old["contraseña"] ?>"
        <?php endif; ?>

        required>
    </div>


    

  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning">Agregar Empleado</button>
      </div>
      </form>
    </div>
  </div>
</div>

    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script defer src="/assets/js/empleados.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaEmpleados').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 