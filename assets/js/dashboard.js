 // Funcionalidad para el menú móvil
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Animación del botón hamburguesa
            const spans = menuBtn.querySelectorAll('span');
            if (sidebar.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(6px, 6px)';
                spans[1].style.opacity = '0';
                spans[1].style.transform = 'translateX(-10px)';
                spans[2].style.transform = 'rotate(-45deg) translate(6px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[1].style.transform = 'none';
                spans[2].style.transform = 'none';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            
            // Resetear animación del botón
            const spans = menuBtn.querySelectorAll('span');
            spans[0].style.transform = 'none';
            spans[1].style.opacity = '1';
            spans[1].style.transform = 'none';
            spans[2].style.transform = 'none';
        }

        // Funcionalidad básica del sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            
            // También cerrar sidebar al hacer clic en un enlace en móvil
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remover clase active de todos los links
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    
                    // Agregar clase active al link clickeado
                    this.classList.add('active');
                    
                    // Cerrar sidebar en móvil
                    if (window.innerWidth <= 1024) {
                        closeSidebar();
                    }
                    
                    // Aquí puedes agregar lógica para cambiar el contenido
                    console.log('Navegando a:', this.textContent.trim());
                });
            });

            // Animación de entrada
            const elements = document.querySelectorAll('.stat-card, .content-area, .sidebar');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });