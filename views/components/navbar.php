<!-- Header -->
<header class="header">
    <div class="header-content">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="user-profile">
            <div class="profile-dropdown" onclick="toggleProfileMenu(event)">
                <div class="profile-info">
                    <div class="profile-name"><?php echo $nombre ?></div>
                    <div class="profile-role"><?php echo $rol ?></div>
                </div>
                <div class="profile-avatar"><?php echo $icono[0] ?></div>
                <div class="dropdown-arrow">▼</div>
            </div>
            <div class="profile-menu" id="profileMenu">
                <div class="menu-item" onclick="window.location.href='/views/perfil.php'">
                    <span class="menu-icon">👤</span>
                    <span class="menu-text">Mi Perfil</span>
                </div>
                <div class="menu-divider"></div>
                <div class="menu-item logout-item" onclick="showLogoutModal()">
                    <span class="menu-icon">🚪</span>
                    <span class="menu-text">Cerrar Sesión</span>
                </div>
            </div>
        </div>
    </div>
</header> 