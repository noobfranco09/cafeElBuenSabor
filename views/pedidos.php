<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <title>Pedidos - CoffeeShop Pro</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Header -->
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
                        <div class="profile-name">Juan Pérez</div>
                        <div class="profile-role">Cocinero</div>
                    </div>
                    <div class="profile-avatar">JP</div>
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

    <!-- Sidebar -->
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
                        <a href="/views/pedidos.php" class="sidebar-link active">
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

    <!-- Modal de confirmación de cierre de sesión -->
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

    <!-- Layout principal -->
    <div class="dashboard-layout">
        <main class="main-content">
            <!-- Header de Pedidos -->
            <div class="orders-header">
                <h2 class="content-title">Pedidos Activos</h2>
            </div>

            <!-- Grid de Pedidos -->
            <div class="orders-grid">
                <!-- Pedido Pendiente -->
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3 class="order-number">#ORD-001</h3>
                            <span class="order-time">Hace 5 min</span>
                        </div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">2x</span>
                                <span class="item-name">Cappuccino Clásico</span>
                            </div>
                            <span class="item-notes">Extra caliente, sin azúcar</span>
                        </div>
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">1x</span>
                                <span class="item-name">Croissant de Chocolate</span>
                            </div>
                            <span class="item-notes">Calentar</span>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-actions">
                            <button class="action-button cancel-btn">
                                ❌ Cancelar
                            </button>
                            <button class="action-button complete-btn">
                                ✅ Realizado
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Otro Pedido -->
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3 class="order-number">#ORD-002</h3>
                            <span class="order-time">Hace 15 min</span>
                        </div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">1x</span>
                                <span class="item-name">Latte Macchiato</span>
                            </div>
                            <span class="item-notes">Leche de almendras</span>
                        </div>
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">2x</span>
                                <span class="item-name">Muffin de Arándanos</span>
                            </div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-actions">
                            <button class="action-button cancel-btn">
                                ❌ Cancelar
                            </button>
                            <button class="action-button complete-btn">
                                ✅ Realizado
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Otro Pedido -->
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3 class="order-number">#ORD-003</h3>
                            <span class="order-time">Hace 25 min</span>
                        </div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">1x</span>
                                <span class="item-name">Espresso Doble</span>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-header">
                                <span class="item-quantity">1x</span>
                                <span class="item-name">Tostada de Aguacate</span>
                            </div>
                            <span class="item-notes">Sin cebolla</span>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-actions">
                            <button class="action-button cancel-btn">
                                ❌ Cancelar
                            </button>
                            <button class="action-button complete-btn">
                                ✅ Realizado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/dashboard.js"></script>
</body>
</html> 