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
    <style>
        @media (max-width: 600px) {
            .content-area {
                padding: 5px !important;
                max-width: 100vw !important;
                min-width: 0 !important;
            }
        }
    </style>
    <title>Empleados</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <header class="header">
        <div class="header-content">
            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="user-profile">
                <div class="profile-dropdown" onclick="toggleProfileMenu(event)">
                    <div class="profile-info">
                        <div class="profile-name"><?php echo $nombre ?></div>
                        <div class="profile-role"><?php echo $rol ?></div>
                    </div>
                    <div class="profile-avatar"><?php echo $icono[0] ?></div>
                    <div class="dropdown-arrow">▼</div>
                </div>
                <div class="profile-menu" id="profileMenu">
                    <div class="menu-item" onclick="goToProfile()">
                        <span class="menu-icon">👤</span>
                        <span class="menu-text">Mi Perfil</span>
                    </div>
                    <div class="menu-divider"></div>
                    <div class="menu-item logout-item" onclick="showLogoutModal()">
                        <span class="menu-icon">🚪</span>
                        <span class="menu-text">Cerrar Sesión</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="company-logo">
                <span class="company-icon">☕</span>
                <div class="company-info">
                    <div class="company-name">CoffeeShop Pro</div>
                    <div class="company-subtitle">Management System</div>
                </div>
            </a>
            <button class="close-sidebar-btn" onclick="closeSidebar()">
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Principal</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="/views/dashboard.php" class="sidebar-link">
                            <span class="sidebar-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/inventario.php" class="sidebar-link">
                            <span class="sidebar-icon">📦</span>
                            Inventario
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/pedidos.php" class="sidebar-link">
                            <span class="sidebar-icon">🛒</span>
                            Pedidos
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">💰</span>
                            Ventas
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">📋</span>
                            Reportes
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/views/empleados.php" class="sidebar-link active">
                            <span class="sidebar-icon">👥</span>
                            Empleados
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-section">
                <h3 class="sidebar-title">Cuenta</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">👤</span>
                            Perfil
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link" onclick="showLogoutModal()">
                            <span class="sidebar-icon">🚪</span>
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <div class="logout-modal" id="logoutModal">
        <div class="modal-overlay" onclick="closeLogoutModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">🚪</div>
                <h3 class="modal-title">Cerrar Sesión</h3>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres cerrar sesión?</p>
                <p class="modal-subtitle">Se cerrará tu sesión actual y tendrás que volver a iniciar sesión.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel-btn" onclick="closeLogoutModal()">
                    Cancelar
                </button>
                <button class="modal-btn confirm-btn" onclick="confirmLogout()">
                    Sí, Cerrar Sesión
                </button>
            </div>
        </div>
    </div>
    <div class="dashboard-layout">
        <main class="main-content">
            <div class="content-area">
                <div class="content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="content-title">Empleados</h2>
                    <button class="action-button" style="margin-bottom: 10px;" onclick="alert('Funcionalidad para agregar empleados próximamente')">Agregar Empleado</button>
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
                            <tr>
                                <td>Juan Pérez</td>
                                <td>2024-06-03 09:00:00</td>
                                <td>555123456</td>
                                <td>juan@example.com</td>
                                <td>Administrador</td>
                                <td>Activo</td>
                                <td>
                                    <button class="btn-editar">Editar</button>
                                    <button class="btn-eliminar">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>María López</td>
                                <td>2023-12-15 14:30:00</td>
                                <td>555987654</td>
                                <td>maria@example.com</td>
                                <td>Empleado</td>
                                <td>Inactivo</td>
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