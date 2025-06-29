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
    
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Solo prevenir el comportamiento por defecto en móvil
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                
                // Remover clase active de todos los links
                sidebarLinks.forEach(l => l.classList.remove('active'));
                
                // Agregar clase active al link clickeado
                this.classList.add('active');
                
                // Cerrar sidebar en móvil
                closeSidebar();
                
                // Navegar a la página después de cerrar el sidebar
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300); // Esperar a que se cierre el sidebar
                }
            }
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

// Funcionalidad del menú desplegable del perfil
function toggleProfileMenu(event) {
    event.stopPropagation();
    const profileDropdown = document.querySelector('.profile-dropdown');
    const profileMenu = document.getElementById('profileMenu');
    
    profileDropdown.classList.toggle('active');
    profileMenu.classList.toggle('active');
}

// Cerrar menú al hacer clic fuera
document.addEventListener('click', function(event) {
    const profileDropdown = document.querySelector('.profile-dropdown');
    const profileMenu = document.getElementById('profileMenu');
    
    if (!profileDropdown.contains(event.target)) {
        profileDropdown.classList.remove('active');
        profileMenu.classList.remove('active');
    }
});

// Funciones para el modal de confirmación de cierre de sesión
function showLogoutModal() {
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'))
    logoutModal.show();
    
    // Cerrar menú desplegable si está abierto
    const profileDropdown = document.querySelector('.profile-dropdown');
    const profileMenu = document.getElementById('profileMenu');
    profileDropdown.classList.remove('active');
    profileMenu.classList.remove('active');
    
    // Cerrar sidebar si está abierto en móvil
    closeSidebar();
}

function closeLogoutModal() {
    const logoutModal = document.getElementById('logoutModal');
    logoutModal.classList.remove('active');
}

function confirmLogout(){
    fetch("../../controller/admin/logout.php",{
        method:"GET",
        headers: {
        'Content-Type': 'application/json'
        }
        
    })
    .then(response => response.json())
    .then(response=>{
         window.location.href=response.redirecion;
    })
  
}