<!-- Modal de confirmación de cierre de sesión -->
<div class="logout-modal" id="logoutModal">
    <div class="modal-overlay" onclick="closeLogoutModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-icon">🚪</div>
            <h3 class="modal-title">Cerrar Sesión</h3>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que quieres cerrar sesión?</p>
            <p class="modal-subtitle">Se cerrará tu sesión actual y tendrás que volver a iniciar sesión.</p>
        </div>
        <div class="modal-footer">
            <button class="modal-btn cancel-btn" onclick="closeLogoutModal()">
                Cancelar
            </button>
            
                <button  class="modal-btn confirm-btn" onclick="confirmLogout()">
                    Sí, Cerrar Sesión
                </button>
            
        </div>
    </div>
</div> 