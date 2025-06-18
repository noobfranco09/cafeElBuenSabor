<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <title>Inventario - CoffeeShop Pro</title>
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
                        <div class="profile-role">Administrador</div>
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
                        <a href="/views/inventario.php" class="sidebar-link active">
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
            <!-- Header de Inventario -->
            <div class="inventory-header">
                <h2 class="content-title">Inventario de Productos</h2>
                <button class="action-button" id="addProductBtn">
                    ➕ Agregar Producto
                </button>
            </div>

            <!-- Grid de Productos -->
            <div class="products-grid">
                <!-- Ejemplo de Card de Producto -->
                <div class="product-card">
                    <div class="product-stock-badge stock-low">Stock bajo</div>
                    <div class="product-image">
                        <img src="/assets/images/products/coffee-beans.jpg" alt="Café Arábica">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Café Arábica Premium</h3>
                        <div class="product-details">
                            <span class="product-category">Granos de Café</span>
                            <span class="product-price">$25.99</span>
                        </div>
                        <div class="product-stock">
                            <span class="stock-label">Stock:</span>
                            <span class="stock-value low-stock">5 unidades</span>
                        </div>
                        <div class="product-actions">
                            <button class="edit-product-btn">
                                ✏️ Editar Producto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Otro ejemplo de Card de Producto -->
                <div class="product-card">
                    <div class="product-stock-badge stock-ok">En stock</div>
                    <div class="product-image">
                        <img src="/assets/images/products/coffee-maker.jpg" alt="Cafetera Express">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Cafetera Express Pro</h3>
                        <div class="product-details">
                            <span class="product-category">Equipamiento</span>
                            <span class="product-price">$299.99</span>
                        </div>
                        <div class="product-stock">
                            <span class="stock-label">Stock:</span>
                            <span class="stock-value">15 unidades</span>
                        </div>
                        <div class="product-actions">
                            <button class="edit-product-btn">
                                ✏️ Editar Producto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Puedes agregar más cards de productos aquí -->
            </div>
        </main>
    </div>

    <script src="/assets/js/dashboard.js"></script>
</body>
</html> 