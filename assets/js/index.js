// Page Loading
window.addEventListener('load', function() {
    setTimeout(() => {
        document.getElementById('pageLoader').style.opacity = '0';
        setTimeout(() => {
            document.getElementById('pageLoader').style.display = 'none';
        }, 500);
    }, 1000);
});

// Create Particles
function createParticles() {
    const particlesContainer = document.getElementById('particles');
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
        particlesContainer.appendChild(particle);
    }
}

// Create floating coffee elements
function createFloatingCoffee() {
    const coffeeEmojis = ['☕', '🥤', '🧁', '🍰'];
    setInterval(() => {
        const floatingElement = document.createElement('div');
        floatingElement.className = 'floating-coffee';
        floatingElement.textContent = coffeeEmojis[Math.floor(Math.random() * coffeeEmojis.length)];
        floatingElement.style.left = Math.random() * 100 + '%';
        floatingElement.style.animationDuration = (Math.random() * 10 + 15) + 's';
        document.body.appendChild(floatingElement);
        
        setTimeout(() => {
            floatingElement.remove();
        }, 25000);
    }, 3000);
}

// ----------Logica para la agregacion al carrito------------------

function actualizarContadorCarrito() {
    let totalCantidad = 0;

    for (let i = 0; i < localStorage.length; i++) {
        const clave = localStorage.key(i);

        // Ignorar claves que no son productos (como nota o total)
        try {
            const producto = JSON.parse(localStorage.getItem(clave));
            if (producto && producto.id && producto.cantidad) {
                totalCantidad += producto.cantidad;
            }
        } catch (e) {
            // probablemente no era un JSON válido de producto
        }
    }

    document.getElementById('cartCount').textContent = totalCantidad;

    // Animation feedback
    const cartElement = document.querySelector('.cart');
    cartElement.style.transform = 'scale(1.1)';
    setTimeout(() => {
        cartElement.style.transform = 'scale(1)';
    }, 200);

}

document.querySelectorAll(".agregar-carrito").forEach(agregarCarrito => {
agregarCarrito.addEventListener('click',function(){

    // Obtenemos los datos del producto para poder agregarlo al localStorage

    const idProducto = this.dataset.id;

    fetch('/cafeElBuenSabor/functions/obtenerProducto.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({idProducto: idProducto})
    })
    .then(response => response.json())
    .then(data => {

        let cantidadProducto = localStorage.getItem(data.idProducto);
        const productoGuardado = JSON.parse(cantidadProducto)

        // if(productoGuardado.cantidad < data.stock)
        // {
       
            const id = data.idProducto;
            const nombre = data.nombre;
            const precio = data.precio;
            const stock = data.stock;
             const carta = document.querySelector("#menu").dataset.carta;

            const producto = {
                id: parseInt(id),
                nombre,
                precio: parseFloat(precio),
                cantidad: 1,
                stock,
                carta
            
            };

            agregarProducto(producto);
        // }else{
        //     alert("no puedes superar el sotck del producto");
        // }

    })

})

// agregar el producto al localStorage

function agregarProducto(producto)
{

    const id = producto.id.toString();
    const idExistente = localStorage.getItem(id);

    if (idExistente) 
    {
        const productoGuardado = JSON.parse(idExistente);
        productoGuardado.cantidad += producto.cantidad;
        localStorage.setItem(id, JSON.stringify(productoGuardado));
        obtenerProductos();
        actualizarContadorCarrito();
    }else{
        localStorage.setItem(id, JSON.stringify(producto));
        obtenerProductos();
        actualizarContadorCarrito();
    }

}

})

// mostrar los productos al carrito

function obtenerProductos()
{
    const carrito = [];

    for (let i = 0; i < localStorage.length; i++) {

        const idProducto = localStorage.key(i);
        const datosProducto = localStorage.getItem(idProducto);

        try {
            const producto = JSON.parse(datosProducto);

            // Asegurar que es un producto válido (opcional pero recomendable)
            if (producto && producto.id && producto.nombre && producto.cantidad) 
            {
                carrito.push(producto);
            }
        } catch (e) {
            console.log("Json invalido");
        }
        
    }

    mostrarProductos(carrito);

}

// funcion para mostrar los productos en el carrito usando DOM

function mostrarProductos(productos)
{

    const contenedorCarrito = document.querySelector("#cartItems");
    const total = document.querySelector("#total");

    contenedorCarrito.innerHTML = "";

    let totalCompra = 0;
    
    productos.forEach((producto) => {

        // Contenedor principal
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");

        // Icono
        const icono = document.createElement("div");
        icono.classList.add("cart-item-icon");
        icono.textContent = "☕";

        // Detalles
        const detalles = document.createElement("div");
        detalles.classList.add("cart-item-details");

        const nombre = document.createElement("div");
        nombre.classList.add("cart-item-name");
        nombre.textContent = producto.nombre;

        const precio = document.createElement("div");
        precio.classList.add("cart-item-price");
        precio.textContent = `$${Number(producto.precio).toLocaleString("es-CO", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;

        detalles.append(nombre, precio);

        // Acciones
        const acciones = document.createElement("div");
        acciones.classList.add("cart-item-actions");

        const btnMenos = document.createElement("button");
        btnMenos.classList.add("quantity-btn");
        btnMenos.dataset.id = producto.id;
        btnMenos.dataset.action = "decrease";
        btnMenos.textContent = "-";

        btnMenos.addEventListener('click', () => {
            disminuirCantidad(producto.id);
        })

        const cantidad = document.createElement("span");
        cantidad.classList.add("quantity-display");
        cantidad.textContent = producto.cantidad;

        const btnMas = document.createElement("button");
        btnMas.classList.add("quantity-btn");
        btnMas.dataset.id = producto.id;
        btnMas.dataset.action = "increase";
        btnMas.textContent = "+";

        btnMas.addEventListener('click', () => {
            aumentarCantidad(producto.id);
        })

        const btnEliminar = document.createElement("button");
        btnEliminar.classList.add("remove-item");
        btnEliminar.dataset.id = producto.id;
        btnEliminar.textContent = "×";

        btnEliminar.addEventListener('click', () => {
            eliminarProducto(producto.id);
        })

        acciones.append(btnMenos, cantidad, btnMas, btnEliminar);

        // Ensamblar todo
        cartItem.append(icono, detalles, acciones);
        contenedorCarrito.appendChild(cartItem);
        
        totalCompra += producto.cantidad * producto.precio;

    })

    total.textContent = "$" + totalCompra.toLocaleString("es-CO");

}

// funcion para amentar la cantidad desde la vista del carrito
function aumentarCantidad(id)
{
    const idExistente = localStorage.getItem(id);

    if (idExistente) 
    {
        const productoGuardado = JSON.parse(idExistente);
        if(productoGuardado.cantidad < productoGuardado.stock)
        {
            productoGuardado.cantidad += 1;
            localStorage.setItem(id, JSON.stringify(productoGuardado));
            obtenerProductos();
            actualizarContadorCarrito();
        }
        else{
            alert('no puedes superar el stock del producto');
        }
    }

}

// funcion para restar la cantidad desde la vista del carrito
function disminuirCantidad(id)
{
    const idExistente = localStorage.getItem(id);

    if (idExistente) 
    {
        const productoGuardado = JSON.parse(idExistente);
        if(productoGuardado.cantidad > 1)
        {
            productoGuardado.cantidad -= 1;
            localStorage.setItem(id, JSON.stringify(productoGuardado));
            obtenerProductos();
            actualizarContadorCarrito();
        }
        else{
            alert('no puedes tener el stock negativo del producto');
        }
    }
}

// funcion para eliminar el producto desde el carrito
function eliminarProducto(id)
{
    localStorage.removeItem(id);
    obtenerProductos();
    actualizarContadorCarrito();
}

const vaciarCarrito = document.querySelector("#vaciarCarrito");

vaciarCarrito.addEventListener('click', () => {

    document.querySelector("#nota").value = '';
    document.querySelector("#total").textContent = '$0';
    localStorage.clear();
    obtenerProductos();
    actualizarContadorCarrito();

});

const finalizarPedido = document.querySelector("#finalizarPedido");

finalizarPedido.addEventListener('click', () => {

    // se agrega al localStorage la nota que el cliente ponga en el textarea
    const nota = document.querySelector("#nota").value;

    let notas = {
        nota
    }

    localStorage.setItem("nota", JSON.stringify(notas));

    // se agrega al localStorage el valor total del pedido
    const total = document.querySelector("#total").textContent;

    let valorTotal = {
        total
    }

    localStorage.setItem("total", JSON.stringify(valorTotal));

    const datosLocalStorage = {};

    for (let i = 0; i < localStorage.length; i++) 
    {
        const clave = localStorage.key(i);
        datosLocalStorage[clave] = localStorage.getItem(clave);
    }
  

    fetch('/cafeElBuenSabor/controller/agregarPedido.php', {
         method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datosLocalStorage)
    })
    .then(response => response.json())
    .then((pedido) => {
        console.log("todo funciona correctamente con el objeto:");
        console.log(pedido);

        // se limpia la informacion del carrito
        document.querySelector("#nota").value = '';
        document.querySelector("#total").textContent = '$0';
        localStorage.clear();
        obtenerProductos();
        actualizarContadorCarrito();
    });

});

document.addEventListener("DOMContentLoaded", () => {
    obtenerProductos();
    actualizarContadorCarrito();
});

// ------------ Fin de la logica del Carrito -----------------------

// Filter products
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    const categoryButtons = document.querySelectorAll('.category-btn');
    
    // Actualizar botones activos
    categoryButtons.forEach(btn => {
        if (btn.dataset.category === category) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Filtrar productos
    products.forEach(product => {
        if (category === 'todos' || product.dataset.category === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });

    // En móvil, hacer scroll suave hasta la sección de productos
    if (window.innerWidth <= 768) {
        const productsSection = document.getElementById('menu');
        const headerHeight = document.querySelector('header').offsetHeight;
        const categoriesBarHeight = document.getElementById('mobileCategoriesBar').offsetHeight;
        const offset = headerHeight + categoriesBarHeight;
        
        window.scrollTo({
            top: productsSection.offsetTop - offset,
            behavior: 'smooth'
        });
    }
}

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(26, 26, 26, 0.98)';
        header.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.3)';
    } else {
        header.style.background = 'rgba(26, 26, 26, 0.95)';
        header.style.boxShadow = 'none';
    }
});

// Initialize
createParticles();
createFloatingCoffee();

// Add intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.8s ease-out';
        }
    });
}, observerOptions);

document.querySelectorAll('.product-card, .category-card').forEach(el => {
    observer.observe(el);
});

// Inicializar la barra de categorías móvil
document.addEventListener('DOMContentLoaded', function() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterProducts(btn.dataset.category);
        });
    });

    // Manejar el scroll para la barra de categorías
    let lastScroll = 0;
    const mobileCategoriesBar = document.getElementById('mobileCategoriesBar');
    
    window.addEventListener('scroll', () => {
        if (window.innerWidth <= 768) {
            const currentScroll = window.pageYOffset;
            const headerHeight = document.querySelector('header').offsetHeight;
            
            if (currentScroll > headerHeight) {
                if (currentScroll > lastScroll) {
                    // Scrolling down
                    mobileCategoriesBar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    mobileCategoriesBar.style.transform = 'translateY(0)';
                }
            }
            
            lastScroll = currentScroll;
        }
    });
});

// Ajustar dinámicamente el top de la barra de categorías móvil según la altura del header
function adjustMobileCategoriesBarTop() {
    if (window.innerWidth <= 768) {
        const header = document.querySelector('header');
        const mobileBar = document.getElementById('mobileCategoriesBar');
        if (header && mobileBar) {
            mobileBar.style.top = header.offsetHeight + 'px';
        }
    } else {
        // Restablecer para desktop
        const mobileBar = document.getElementById('mobileCategoriesBar');
        if (mobileBar) {
            mobileBar.style.top = '';
        }
    }
}

window.addEventListener('DOMContentLoaded', adjustMobileCategoriesBarTop);
window.addEventListener('resize', adjustMobileCategoriesBarTop);

// Función para mostrar/ocultar el carrito
function toggleCart(event) {
    event.preventDefault();
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay');
    
    cartSidebar.classList.toggle('open');
    cartOverlay.classList.toggle('active');
    
    // Prevenir scroll del body cuando el carrito está abierto
    if (cartSidebar.classList.contains('open')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}