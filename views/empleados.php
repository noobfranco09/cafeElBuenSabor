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
$erroresEditar = $_SESSION["erroresEditar"]??[];
$old = $_SESSION["old"]??[];
$abrirModal = $_SESSION["abrirModal"]??false;
$abrirMdlEditar = $_SESSION["abirMdlEditar"]??false;
$idEditar = $_SESSION["idEditar"]??"";
$usrActualizado = $_SESSION["usrActualizado"]??false;

unset($_SESSION["errores"],$_SESSION["old"],$_SESSION["abrirModal"],$_SESSION["erroresEditar"],$_SESSION["abirMdlEditar"],$_SESSION["id
Editar"],$_SESSION["usrActualizado"]);

//Para traer los datos de la BD

require_once '../models/mySql.php';
$mysql = new MySQL;
$mysql->conectar();
$consulta = "SELECT usuario.idUsuario,usuario.nombre,usuario.fechaIngreso,usuario.telefono,usuario.correo,usuario.estado,roles.nombre AS nombreRol FROM usuario
JOIN roles ON roles.idRoll = usuario.idRoll";
$stmt = $mysql->obtenerConexion()->query($consulta);

$consultaRol = "SELECT * FROM roles";
$stmtRol = $mysql->obtenerConexion()->query($consultaRol);
$stmtRolEditar = $mysql->obtenerConexion()->query($consultaRol);
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
    <link rel="stylesheet" href="/assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
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
            <div class="section-header section-header-visual">
              <div class="section-title">
                <span class="section-icon">👥</span>
                <div>
                  <h2>Gestión de Empleados</h2>
                  <p class="section-subtitle">Administra la información y el estado del personal</p>
                </div>
              </div>
            </div>
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
                        <tbody id="tablaUsuarios">
                            <?php while($usuarios = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $usuarios["nombre"] ?></td>
                                <td><?php echo $usuarios["fechaIngreso"] ?></td>
                                <td><?php echo $usuarios["telefono"] ?></td>
                                <td><?php echo $usuarios["correo"] ?></td>
                                <td><?php echo $usuarios["nombreRol"] ?></td>
                                <td><?php echo $usuarios["estado"] ?></td>
                                <td>
                                    <button type="button" data-id="<?php echo $usuarios["idUsuario"]?>" class="btn btn-warning btn-sm btnEditar"><i class="bi bi-pencil-square "></i></button>
                                    <?php if($usuarios["estado"]=="Activo"): ?>
                                    <button type="button" data-id="<?php echo $usuarios["idUsuario"] ?>" class="btn btn-danger btn-sm btnDesactivar"><i class="bi bi-trash "></i></button></a>
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
<!-- Agregar--------------- -->
<div class="modal fade" id="mdlAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Empleado</h1>
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
            <select class="form-select" aria-label="Elije un rol" name="rol" id="rol">
            <?php while($roles = $stmtRol->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $roles["idRoll"]?>"><?php echo $roles["nombre"]?></option>
            <?php endwhile; ?>
        </select>
        
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



<!-- EDITAR----------------------------- -->
<div class="modal fade" id="mdlEditar" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <form id="formAgregar" action="../controller/editarEmpleado.php" method="POST" >
       
    <?php if(!empty($erroresEditar["datosVacios"]) && isset($erroresEditar["datosVacios"])): ?>
        <p class="text-start text-danger"><?php echo $erroresEditar["datosVacios"] ?></p>
    <?php endif; ?>


    <input type="hidden" name="id" id="idUsuario" value="<?php echo $idEditar ?>">

    <!-- Nombre -->
    <div class="mb-3">
         <?php if(!empty($erroresEditar["errorNombre"]) && isset($erroresEditar["errorNombre"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["errorNombre"] ?></p>
        <?php endif; ?>
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombreEditar" name="nombre" placeholder="Ingrese el nombre" required>
    </div>


      <!-- Fecha Ingreso -->
    <div class="mb-3">
        <?php if(!empty($erroresEditar["errorFecha"]) && isset($erroresEditar["errorFecha"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["errorFecha"] ?></p>
        <?php endif; ?>
        <label for="fecha" class="form-label">Fecha Ingreso</label>
        <input type="date" class="form-control" id="fechaEditar" name="fecha" placeholder="Ingrese la fecha"required>
    </div>


     <!-- Telefono -->
    <div class="mb-3">
        <?php if(!empty($erroresEditar["errorTelefono"]) && isset($erroresEditar["errorTelefono"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["errorTelefono"] ?></p>
        <?php endif; ?>
        <label for="telefono" class="form-label">Telefono</label>
        <input type="text" class="form-control" id="telefonoEditar" name="telefono" placeholder="Ingrese el telefono" required>
    </div>


     <!-- Correo -->
    <div class="mb-3">
        <?php if(!empty($erroresEditar["errorCorreo"]) && isset($erroresEditar["errorCorreo"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["errorCorreo"] ?></p>
        <?php endif; ?>
        <?php if(!empty($erroresEditar["correoEnUso"]) && isset($erroresEditar["correoEnUso"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["correoEnUso"] ?></p>
        <?php endif; ?>
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correoEditar" name="correo" placeholder="Ingrese el correo"required>
    </div>


      <!-- Rol -->
    <div class="mb-3">
        <?php if(!empty($erroresEditar["errorRol"]) && isset($erroresEditar["errorRol"])): ?>
            <p class="text-start text-danger"><?php echo $erroresEditar["errorRol"] ?></p>
        <?php endif; ?>
        <label for="rol"  class="form-label">Rol</label>
            <select class="form-select" aria-label="Elije un rol" name="rol" id="rolEditar">
                <?php while($rolesEditar = $stmtRolEditar->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $rolesEditar["idRoll"]?>"><?php echo $rolesEditar["nombre"]?></option>
                <?php endwhile; ?>
            </select>
        
    </div>

     <!-- Contraseña -->
    <div class="mb-3">
        <label for="contraseña"  class="form-label">Contraseña</label>
        <input type="text" class="form-control" id="contraseñaEditar" name="contraseña" placeholder="Ingrese la Contraseña " required>
    </div>

    <div class="mb-3">
        <label for="estadoEditar"  class="form-label">Estado</label>
        <select class="form-select" aria-label="Elije un rol" name="estado" id="estadoEditar" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
        </select>
        

        
    </div>


    

  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning">Actualizar Empleado</button>
      </div>
      </form>
    </div>
  </div>
</div>

    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../assets\node_modules\sweetalert2\dist\sweetalert2.all.min.js"></script>
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
    
    <?php if($abrirModal):?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {abrirModal()});
        </script>
    <?php endif;?>
    <?php if($abrirMdlEditar):?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {obtenerUsuario(<?php echo $idEditar?>)});
        </script>
    <?php endif;?>
     <?php if($usrActualizado):?>
        <script>
            Swal.fire({
                    title: "Actualizado con exito!",
                    text: "El usuario ah sido actualizado.",
                    icon: "success"
                    });
        </script>
    <?php endif;?>



</body>
</html> 