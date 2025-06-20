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
    <title>Pedidos - CoffeeShop Pro</title>
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
        $activePage = 'pedidos';
        include './components/sidebar.php'; 
    ?>

    <?php include './components/logoutModal.php'; ?>

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
                            <span class="item-notes empty">Sin nota</span>
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
                            <span class="item-notes empty">Sin nota</span>
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