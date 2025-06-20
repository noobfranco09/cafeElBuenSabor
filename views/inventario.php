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
    <title>Inventario de Ingredientes</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <?php include './components/navbar.php'; ?>
    <?php 
        $activePage = 'inventario';
        include './components/sidebar.php'; 
    ?>
    <?php include './components/logoutModal.php'; ?>
    <div class="dashboard-layout">
        <main class="main-content">
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <h2 class="content-title">Inventario de Ingredientes</h2>
                    <button class="action-button" style="margin-bottom: 10px;" onclick="alert('Funcionalidad para agregar ingrediente próximamente')">Agregar Ingrediente</button>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="tablaInventario" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Café en grano</td>
                                <td>Café arábica premium</td>
                                <td><span class="badge badge-success">Activo</span></td>
                                <td>
                                    <button class="btn-editar">Editar</button>
                                    <button class="btn-eliminar">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Leche</td>
                                <td>Leche entera pasteurizada</td>
                                <td><span class="badge badge-success">Activo</span></td>
                                <td>
                                    <button class="btn-editar">Editar</button>
                                    <button class="btn-eliminar">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Chocolate</td>
                                <td>Chocolate en polvo para bebidas</td>
                                <td><span class="badge badge-danger">Inactivo</span></td>
                                <td>
                                    <button class="btn-editar">Editar</button>
                                    <button class="btn-eliminar">Eliminar</button>
                                </td>
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
            $('#tablaInventario').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html> 