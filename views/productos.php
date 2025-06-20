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
    <title>Productos - CoffeeShop Pro</title>
</head>
<body>
    <!-- Círculos decorativos -->
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <?php include './components/navbar.php'; ?>

    <?php 
        $activePage = 'productos';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

    <!-- Layout principal -->
    <div class="dashboard-layout">
        <main class="main-content">
            <!-- Header de Inventario -->
            <div class="inventory-header">
                <h2 class="content-title">Productos</h2>
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