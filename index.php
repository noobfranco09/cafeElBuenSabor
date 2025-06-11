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
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#menu">Menú</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <a href="#" class="cart">
                🛒 Carrito
                <span class="cart-count" id="cartCount">0</span>
            </a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <div class="hero-content">
            <h1>Café & Bebidas El Buen Sabor</h1>
            <p>Disfruta de los mejores cafés y bebidas preparados con amor, dedicación y los granos más selectos del mundo</p>
            <a href="#menu" class="cta-button">Explorar Menú</a>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories">
        <h2>Nuestras Especialidades</h2>
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
    </section>

    <!-- Products -->
    <section class="products" id="menu">
        <h2>Nuestro Menú Premium</h2>
        <div class="products-grid" id="productsGrid">
            <div class="product-card" data-category="cafes">
                <div class="product-image">☕</div>
                <div class="product-info">
                    <h3>Café Americano Premium</h3>
                    <p>Café negro puro, intenso y aromático preparado con granos seleccionados de Colombia</p>
                    <div class="product-footer">
                        <span class="price">$3,500</span>
                        <button class="add-btn" onclick="addToCart('Café Americano', 3500)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="cafes">
                <div class="product-image">☕</div>
                <div class="product-info">
                    <h3>Cappuccino Artesanal</h3>
                    <p>Espresso perfecto con leche espumada y canela, creando una sinfonía de sabores</p>
                    <div class="product-footer">
                        <span class="price">$4,500</span>
                        <button class="add-btn" onclick="addToCart('Cappuccino', 4500)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="cafes">
                <div class="product-image">☕</div>
                <div class="product-info">
                    <h3>Latte Supremo</h3>
                    <p>Espresso suave con leche cremosa y un toque de vainilla que despierta los sentidos</p>
                    <div class="product-footer">
                        <span class="price">$4,200</span>
                        <button class="add-btn" onclick="addToCart('Latte', 4200)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="cafes">
                <div class="product-image">☕</div>
                <div class="product-info">
                    <h3>Mocha Deluxe</h3>
                    <p>La combinación perfecta de café, chocolate belga y crema batida artesanal</p>
                    <div class="product-footer">
                        <span class="price">$5,200</span>
                        <button class="add-btn" onclick="addToCart('Mocha Deluxe', 5200)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="bebidas">
                <div class="product-image">🥤</div>
                <div class="product-info">
                    <h3>Frappé Caramelo</h3>
                    <p>Bebida helada con café, caramelo y crema batida, perfecta para días calurosos</p>
                    <div class="product-footer">
                        <span class="price">$4,800</span>
                        <button class="add-btn" onclick="addToCart('Frappé Caramelo', 4800)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="bebidas">
                <div class="product-image">🧊</div>
                <div class="product-info">
                    <h3>Smoothie Tropical</h3>
                    <p>Mezcla refrescante de frutas tropicales con yogurt griego y miel natural</p>
                    <div class="product-footer">
                        <span class="price">$4,000</span>
                        <button class="add-btn" onclick="addToCart('Smoothie Tropical', 4000)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="postres">
                <div class="product-image">🧁</div>
                <div class="product-info">
                    <h3>Cheesecake de Café</h3>
                    <p>Delicioso cheesecake con infusión de café y crema de baileys</p>
                    <div class="product-footer">
                        <span class="price">$3,800</span>
                        <button class="add-btn" onclick="addToCart('Cheesecake Café', 3800)">Agregar</button>
                    </div>
                </div>
            </div>
            
            <div class="product-card" data-category="postres">
                <div class="product-image">🍰</div>
                <div class="product-info">
                    <h3>Tiramisú Clásico</h3>
                    <p>El postre italiano por excelencia con mascarpone, café y cacao</p>
                    <div class="product-footer">
                        <span class="price">$4,200</span>
                        <button class="add-btn" onclick="addToCart('Tiramisú', 4200)">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="/assets/js/index.js"></script>

</body>
</html>