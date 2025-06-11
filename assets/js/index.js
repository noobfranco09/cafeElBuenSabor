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
            products.forEach(product => {
                if (category === 'todos' || product.dataset.category === category) {
                    product.style.display = 'block';
                    product.style.animation = 'fadeInUp 0.5s ease-out';
                } else {
                    product.style.display = 'none';
                }
            });
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