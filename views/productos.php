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
echo var_dump($errores);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/boostrap/bootstrap.min.css">
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
            <div class="section-header section-header-visual" style="justify-content: space-between;">
                <div class="section-title">
                    <span class="section-icon">📦</span>
                    <div>
                        <h2>Gestión de Productos</h2>
                        <p class="section-subtitle">Administra el inventario y los detalles de los productos</p>
                    </div>
                </div>
                <button class="action-button" data-bs-toggle="modal" data-bs-target="#AgregarModal">
                    ➕ Agregar Producto
                </button>
            </div>

            <!-- Grid de Productos -->
            <div class="products-grid products-grid-modern">
                <!-- Ejemplo de Card de Producto -->
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <img src="/assets/images/products/coffee-beans.jpg" alt="Café Arábica">
                        <span class="product-stock-badge-modern stock-low">Stock bajo</span>
                    </div>
                    <div class="product-info-modern">
                        <h3 class="product-name-modern">Café Arábica Premium</h3>
                        <div class="product-details-modern">
                            <span class="product-category-modern">Granos de Café</span>
                        </div>
                        <div class="product-price-modern">Precio: $25.99</div>
                        <div class="product-description-modern">Café de alta calidad, sabor intenso y aroma único.</div>
                        <div class="product-stock-modern">Stock: <span class="stock-value-modern low-stock">5 unidades</span></div>
                        <div class="product-actions-modern">
                            <button class="edit-product-btn-modern">✏️ Editar</button>
                            <button class="delete-product-btn-modern">🗑️ Eliminar</button>
                        </div>
                        <div class="product-status-badge active">Activo</div>
                    </div>
                </div>
                <!-- Otra Card de Producto -->
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <img src="/assets/images/products/coffee-maker.jpg" alt="Cafetera Express">
                        <span class="product-stock-badge-modern stock-ok">En stock</span>
                    </div>
                    <div class="product-info-modern">
                        <h3 class="product-name-modern">Cafetera Express Pro</h3>
                        <div class="product-details-modern">
                            <span class="product-category-modern">Equipamiento</span>
                        </div>
                        <div class="product-price-modern">Precio: $299.99</div>
                        <div class="product-description-modern">Cafetera profesional para preparar espresso en casa.</div>
                        <div class="product-stock-modern">Stock: <span class="stock-value-modern">15 unidades</span></div>
                        <div class="product-actions-modern">
                            <button class="edit-product-btn-modern">✏️ Editar</button>
                            <button class="delete-product-btn-modern">🗑️ Eliminar</button>
                        </div>
                        <div class="product-status-badge inactive">Inactivo</div>
                    </div>
                </div>
                <!-- Puedes agregar más cards aquí -->
            </div>
        </main>
    </div>

        <!-- Modal Agregar -->
    <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content bg-white" style="max-height: 90vh; overflow-y: auto;">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="AgregarModalLabel">Agregar Producto</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3" action="../controller/AgregarProducto.php" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                    <?php if(isset($old["nombre"]) && !empty($old["nombre"])):  ?>
                        value="<?php echo $old["nombre"]; ?>"
                    <?php endif;  ?> required>

                    <?php if(!empty($errores["nombreInvalido"]) && isset($errores["nombreInvalido"])): ?>
                        <p class="text-start text-danger"><?php echo $errores["nombreInvalido"] ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" required>
                </div>
                <div class="col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="col-md-6">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required>
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" name="estado" id="estado" required>
                        <option value="">Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                </div>
                <div class="col-12">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar Producto</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
</body>
</html> 