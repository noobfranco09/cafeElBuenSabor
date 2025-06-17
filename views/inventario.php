<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/boostrap/bootstrap.min.css">
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
                <div class="profile-info">
                    <div class="profile-name">Juan Pérez</div>
                    <div class="profile-role">Administrador</div>
                </div>
                <div class="profile-avatar">JP</div>
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
                        <a href="#" class="sidebar-link">
                            <span class="sidebar-icon">🚪</span>
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Layout principal -->
    <div class="dashboard-layout">
        <main class="main-content">
            <!-- Header de Inventario -->
            <div class="inventory-header">
                <h2 class="content-title">Inventario de Productos</h2>
                <button class="action-button" data-bs-toggle="modal" data-bs-target="#AgregarModal">
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

    <!-- Modal Agregar -->
    <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AgregarModalLabel">Agregar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="row g-3">
                        <div class="col-12">
                            <label for="nombreProducto" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="precioProducto" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="precioProducto" name="precioProducto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stockProducto" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stockProducto" name="stockProducto" required>
                        </div>
                        <div class="col-12">
                            <label for="categoriaProducto" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="categoriaProducto" name="categoriaProducto" required>
                        </div>
                        <div class="col-12">
                            <label for="descripcionProducto" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcionProducto" name="descripcionProducto" required>
                        </div>
                        <div class="col-12">
                            <label for="imagenProducto" class="form-label">Subir Imagen</label>
                            <input type="file" class="form-control" name="imagenProducto" id="imagenProducto" required>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <img src="../assets/img/acidos.jpg" alt="" height="100px;" width="100px;">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>

</body>

</html>