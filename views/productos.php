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
            <div class="inventory-header">
                <h2 class="content-title">Productos</h2>
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
                    <input type="text" class="form-control" id="estado" name="estado" required>
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
</body>
</html> 