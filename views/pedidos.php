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
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/cafeElBuenSabor/assets/css/dashboard.css">
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
            <!-- Header mejorado de Pedidos -->
            <div class="orders-header-enhanced">
                <div class="header-content">
                    <div class="header-left">
                        <h1 class="header-title">
                            <i class="bi bi-cup-hot-fill"></i>
                            Gestión de Pedidos
                        </h1>
                        <p class="header-subtitle">Administra y monitorea todos los pedidos en tiempo real</p>
                    </div>
                    <div class="header-right">
                        <div class="order-stats">
                            <div class="stat-item">
                                <span class="stat-number" id="pedidosActivos">0</span>
                                <span class="stat-label">Activos</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" id="pedidosPreparacion">0</span>
                                <span class="stat-label">En Preparación</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" id="pedidosCompletados">0</span>
                                <span class="stat-label">Completados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros expandibles -->
            <div class="orders-filters" id="ordersFilters" style="display: none;">
                <div class="filters-content">
                    <div class="filter-group">
                        <label for="statusFilter">Estado:</label>
                        <select id="statusFilter" class="filter-select">
                            <option value="">Todos</option>
                            <option value="activo">Activos</option>
                            <option value="preparacion">En Preparación</option>
                            <option value="completado">Completados</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="dateFilter">Fecha:</label>
                        <input type="date" id="dateFilter" class="filter-input">
                    </div>
                    <div class="filter-group">
                        <label for="searchFilter">Buscar:</label>
                        <input type="text" id="searchFilter" class="filter-input" placeholder="Número de pedido, mesa...">
                    </div>
                    <div class="filter-actions">
                        <button class="apply-filters-btn" onclick="applyFilters()">Aplicar</button>
                        <button class="clear-filters-btn" onclick="clearFilters()">Limpiar</button>
                    </div>
                </div>
            </div>

            <!-- Contenedor TBS para Pedidos -->
            <div class="tbs-container">
                <!-- Sección de Pedidos Activos -->
                <div class="tbs-section" id="pedidosActivosSection">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <h2>Pedidos Activos</h2>
                            <span class="section-badge active-badge" id="activeCount">0</span>
                        </div>
                        <div class="section-actions">
                            <button class="section-action-btn" onclick="refreshActiveOrders()">
                                🔄
                            </button>
                            <button class="section-action-btn" onclick="toggleActiveSection()">
                                <span id="activeToggleIcon">⬇️</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="section-content" id="activeOrdersContent">
                        <div class="orders-grid" id="activeOrdersGrid">
                            <!-- Los pedidos activos se cargarán dinámicamente aquí -->
                            <!-- Ejemplo de Card de Pedido Activo (Diseño Moderno) -->
                            <div class="order-card-modern">
                              <div class="order-card-header">
                                <div>
                                  <span class="order-card-number">#1234</span>
                                  <span class="order-card-time"><i class="bi bi-clock"></i> 10:45 AM</span>
                                </div>
                                <div class="order-card-table"><i class="bi bi-table"></i> Mesa 5</div>
                              </div>
                              <div class="order-card-items">
                                <div class="order-card-item"><i class="bi bi-cup-hot"></i> 2x Café Latte</div>
                                <div class="order-card-item"><i class="bi bi-cup-straw"></i> 1x Jugo Naranja</div>
                                <div class="order-card-item"><i class="bi bi-cake"></i> 1x Croissant</div>
                              </div>
                              <div class="order-card-footer">
                                <div class="order-card-client"><i class="bi bi-person"></i> Juan Pérez</div>
                              </div>
                              <div class="order-card-note">
                                <i class="bi bi-chat-left-text"></i>
                                <span><strong>NOTA:</strong> Sin azúcar, por favor.</span>
                              </div>
                              <div class="order-card-actions">
                                <button class="order-btn-cancel"><i class="bi bi-x-circle"></i> Cancelar</button>
                                <button class="order-btn-prepare"><i class="bi bi-check-circle"></i> Preparar</button>
                              </div>
                            </div>
                            <!-- Fin ejemplo card moderno -->
                            <div class="loading-placeholder">
                                <i class="bi bi-hourglass-split"></i>
                                <p>Cargando pedidos activos...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de Pedidos en Preparación -->
                <div class="tbs-section" id="pedidosPreparacionSection">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-gear-fill"></i>
                            <h2>En Preparación</h2>
                            <span class="section-badge preparation-badge" id="preparationCount">0</span>
                        </div>
                        <div class="section-actions">
                            <button class="section-action-btn" onclick="refreshPreparationOrders()">
                                🔄
                            </button>
                            <button class="section-action-btn" onclick="togglePreparationSection()">
                                <span id="preparationToggleIcon">⬇️</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="section-content" id="preparationOrdersContent">
                        <div class="orders-grid" id="preparationOrdersGrid">
                            <!-- Los pedidos en preparación se cargarán dinámicamente aquí -->
                            <div class="loading-placeholder">
                                <i class="bi bi-hourglass-split"></i>
                                <p>Cargando pedidos en preparación...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de Pedidos Completados (Opcional) -->
                <div class="tbs-section collapsed" id="pedidosCompletadosSection">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-check-circle-fill"></i>
                            <h2>Completados Hoy</h2>
                            <span class="section-badge completed-badge" id="completedCount">0</span>
                        </div>
                        <div class="section-actions">
                            <button class="section-action-btn" onclick="refreshCompletedOrders()">
                                🔄
                            </button>
                            <button class="section-action-btn" onclick="toggleCompletedSection()">
                                <span id="completedToggleIcon">⬇️</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="section-content collapsed" id="completedOrdersContent">
                        <div class="orders-grid" id="completedOrdersGrid">
                            <!-- Los pedidos completados se cargarán dinámicamente aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/cafeElBuenSabor/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
</body>
</html> 