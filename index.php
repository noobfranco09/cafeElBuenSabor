<?php

require_once './models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();

$mostrarProductos = "SELECT * FROM productos";

$smts = $mysql->obtenerConexion()->prepare($mostrarProductos);
$smts->execute();


$mysql->desconectar();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/index.css">
    <title>El Buen Sabor - Café Premium</title>
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <!-- Particles Background -->
    <div class="particles" id="particles"></div>

    <!-- Header -->
    <header>
        <nav>
            <div class="logo">El Buen Sabor</div>
            <a href="#" class="cart" onclick="toggleCart(event)">
                🛒 Carrito
                <span class="cart-count" id="cartCount">0</span>
            </a>
        </nav>
    </header>

    <!-- Carrito deslizable -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>🛒 Tu Carrito</h3>
            <button class="close-cart" onclick="toggleCart(event)">×</button>
        </div>
        <div class="cart-items" id="cartItems">


            <!-- Aqui van los productos del carrito cargados desde el DOM -->
           

        </div>
        <div class="cart-notes-section">
            <h4>📝 Notas del Pedido</h4>
            <div class="notes-container">
                <textarea 
                    id="orderNotes" 
                    placeholder="Agrega notas especiales para tu pedido (ej: sin azúcar, extra caliente, sin hielo, etc.)"
                    rows="3"
                ></textarea>
                <div class="notes-examples">
                    <span class="note-example">☕ Sin azúcar</span>
                    <span class="note-example">🔥 Extra caliente</span>
                    <span class="note-example">🧊 Sin hielo</span>
                    <span class="note-example">🥛 Leche de almendras</span>
                </div>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="total-amount" id="cartTotal">$0</span>
            </div>
            <button class="clear-cart-btn" id="vaciarCarrito">Vaciar Carrito</button>
            <button class="checkout-btn" onclick="checkout()">Finalizar Pedido</button>
        </div>
    </div>
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart(event)"></div>

    <!-- Barra de categorías móvil -->
    <div class="mobile-categories-bar" id="mobileCategoriesBar">
        <button class="category-btn active" data-category="todos">
            <span class="category-icon">🍽️</span>
            <span class="category-name">Todos</span>
        </button>
        <button class="category-btn" data-category="cafes">
            <span class="category-icon">☕</span>
            <span class="category-name">Cafés</span>
        </button>
        <button class="category-btn" data-category="bebidas">
            <span class="category-icon">🥤</span>
            <span class="category-name">Bebidas</span>
        </button>
        <button class="category-btn" data-category="postres">
            <span class="category-icon">🧁</span>
            <span class="category-name">Postres</span>
        </button>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <div class="hero-content">
            <h1>Café & Bebidas El Buen Sabor</h1>
            <p>Disfruta de los mejores cafés y bebidas preparados con amor, dedicación y los granos más selectos del mundo</p>
            <a href="#menu" class="cta-button">Explorar Menú</a>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories desktop-only">
        <h2>Nuestras Especialidades</h2>
        <a href="#menu">
            <div class="category-grid">
            <div class="category-card" onclick="filterProducts('todos')">
                <span class="category-icon">🍽️</span>
                <h3>Todos los Productos</h3>
                <p>Explora nuestra completa selección de cafés, bebidas y postres artesanales</p>
            </div>
            <div class="category-card" onclick="filterProducts('cafes')">
                <span class="category-icon">☕</span>
                <h3>Cafés Especiales</h3>
                <p>Desde espressos intensos hasta lattes cremosos, cada taza es una experiencia única</p>
            </div>
            <div class="category-card" onclick="filterProducts('bebidas')">
                <span class="category-icon">🥤</span>
                <h3>Bebidas Frías</h3>
                <p>Refrescantes bebidas perfectas para cualquier momento del día</p>
            </div>
            <div class="category-card" onclick="filterProducts('postres')">
                <span class="category-icon">🧁</span>
                <h3>Postres</h3>
                <p>Deliciosos acompañamientos que complementan perfectamente tu bebida favorita</p>
            </div>
        </div>
        </a>
    </section>

    <!-- Products -->
    <section class="products" id="menu">
        <h2 class="desktop-only">Nuestro Menú Premium</h2>

        <?php while($mostrarProducto = $smts->fetch(PDO::FETCH_ASSOC)) :   ?>

        <div class="products-grid" id="productsGrid">

            <div class="product-card" data-category="cafes">
                <div class="product-image"><?php echo $mostrarProducto['imagen']; ?></div>
                <div class="product-info">
                    <h3><?php echo $mostrarProducto['nombre']; ?></h3>
                    <p><?php echo $mostrarProducto['descripcion']; ?></p>
                    <div class="product-footer">
                        <span class="price"><?php echo $mostrarProducto['precio']; ?></span>
                        <button class="add-btn agregar-carrito" data-id="<?php echo $mostrarProducto['idProducto']; ?>">Agregar</button>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>

        </div>
    </section>


    <script src="/assets/js/index.js"></script>

</body>
</html>