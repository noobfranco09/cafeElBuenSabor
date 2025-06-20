let cart = [];
let cartCount = 0;

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

// Add to cart function
function addToCart(productName, price) {
    cart.push({ name: productName, price: price });
    cartCount++;
    document.getElementById('cartCount').textContent = cartCount;
    
    // Animation feedback
    const cartElement = document.querySelector('.cart');
    cartElement.style.transform = 'scale(1.1)';
    setTimeout(() => {
        cartElement.style.transform = 'scale(1)';
    }, 200);
}

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