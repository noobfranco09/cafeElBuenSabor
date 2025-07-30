<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeElBuenSabor/functions/rutas.php';

if (!isset($_SESSION["id"])) {
    header("Location: " . BASE_URL . "views/login.php");
    exit();
}
if ($_SESSION["estado"] == "Inactivo") {
    header("Location: " . BASE_URL . "views/login.php");
    exit();
}

$nombre = $_SESSION["nombre"] ?? "Desconocido";
$rol = $_SESSION["rol"] ?? "Desconocido";
$icono = str_split($nombre) ?? "?";

$errores = $_SESSION["errores"] ?? [];
$old = $_SESSION["old"] ?? [];
unset($_SESSION["errores"], $_SESSION["old"]);

require_once BASE_PATH . 'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$obtenerProductos = $conexion->query("SELECT productos.idProducto, productos.nombre, productos.descripcion, productos.precio, 
productos.stock, productos.imagen, productos.estado, categorias.nombre As nombreCategoria
FROM productos JOIN categorias ON categorias.idCategoria = productos.idCategoria ");

$obtenerCategorias = $conexion->query("SELECT * FROM categorias");

$mysql->desconectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/dashboard.css">
    <title>Productos - CoffeeShop Pro</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <?php include BASE_PATH . 'views/components/navbar.php'; ?>

    <?php 
        $activePage = 'productos';
        include BASE_PATH . 'views/components/sidebar.php'; 
    ?>

    <?php include BASE_PATH . 'views/components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content">
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

            <div class="products-grid products-grid-modern">
                <?php while($mostrarProductos = $obtenerProductos->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <img src="<?php echo $mostrarProductos["imagen"]; ?>">
                        <?php if($mostrarProductos["stock"] <= 5): ?>
                            <span class="product-stock-badge-modern stock-low">Stock bajo</span>
                        <?php else: ?>
                            <span class="product-stock-badge-modern stock-ok">En stock</span>
                        <?php endif ?>
                    </div>
                    <div class="product-info-modern">
                        <h3 class="product-name-modern"><?php echo $mostrarProductos["nombre"]; ?></h3>
                        <div class="product-details-modern">
                            <span class="product-category-modern"><?php echo $mostrarProductos["nombreCategoria"]; ?></span>
                        </div>
                        <div class="product-price-modern">Precio: $<?php echo number_format($mostrarProductos['precio'], 0, ',', '.'); ?></div>
                        <div class="product-description-modern"><?php echo $mostrarProductos["descripcion"]; ?></div>
                        <?php if($mostrarProductos["stock"] <= 5): ?>
                            <div class="product-stock-modern">Stock: <span class="stock-value-modern low-stock"><?php echo $mostrarProductos["stock"]; ?> Unidades</span></div>
                        <?php else: ?>
                            <div class="product-stock-modern">Stock: <span class="stock-value-modern"><?php echo $mostrarProductos["stock"]; ?> Unidades</span></div>
                        <?php endif ?>
                        <div class="product-actions-modern">
                            <button class="action-button btnEditarProducto" data-bs-toggle="modal" data-bs-target="#modalEditar" data-id="<?php echo $mostrarProductos['idProducto']; ?>">✏️ Editar</button>
                            <form action="<?php echo BASE_URL ?>controller/admin/eliminarProducto.php" method="POST">
                                <input type="hidden" name="eliminarIdProducto" value="<?php echo $mostrarProductos['idProducto']; ?>">
                                <button class="btn btn-danger">🗑️ Eliminar</button>
                            </form>
                        </div>
                        <?php if($mostrarProductos["estado"] == "Activo"): ?>
                            <div class="product-status-badge active"><?php echo $mostrarProductos["estado"]; ?></div>
                        <?php else: ?>
                            <div class="product-status-badge inactive"><?php echo $mostrarProductos["estado"]; ?></div>
                        <?php endif ?>
                    </div>
                </div>
                <?php endwhile; ?>
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
                    <form class="row g-3" action="<?php echo BASE_URL ?>controller/AgregarProducto.php" method="POST" enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $old['nombre'] ?? ''; ?>" required>
                            <?php if(!empty($errores["nombreInvalido"])): ?>
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
                            <label for="categoria" class="form-label">Categoría</label>
                            <select name="categoria" id="categoria" class="form-control" required>
                                <option value="" selected disabled>Selecciona una categoría...</option>
                                <?php while($mostrarCategorias = $obtenerCategorias->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <option value="<?php echo $mostrarCategorias['idCategoria']?>"><?php echo $mostrarCategorias['nombre']?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" name="estado" id="estado" required>
                                <option value="">Selecciona un estado...</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripción</label>
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

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content bg-white" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Editar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" action="<?php echo BASE_URL ?>controller/admin/editarProducto.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editarIdProducto" name="editarIdProducto" required readonly>
                        <div class="col-12">
                            <label for="editarNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="editarPrecio" name="precio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarStock" class="form-label">Stock</label>
                            <input type="text" class="form-control" id="editarStock" name="stock" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarCategoria" class="form-label">Categoría</label>
                            <select name="editarCategoria" id="editarCategoria" class="form-control" required>
                                <option value="" disabled selected>Elija una categoría</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="editarDescripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="editarDescripcion" name="descripcion" required>
                        </div>
                        <div class="col-12">
                            <label for="editarImagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="editarImagen" name="editarImagen" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL ?>assets/js/editarProducto.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/dashboard.js"></script>
</body>
</html>
