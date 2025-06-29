<!-- Modal de confirmación de cierre de sesión (Bootstrap) -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-icon"><i class="bi bi-box-arrow-right" style="font-size:2rem;color:#A0522D;"></i></span>
        <h5 class="modal-title ms-2" id="logoutModalLabel">Cerrar Sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que quieres cerrar sesión?</p>
        <p class="text-muted">Se cerrará tu sesión actual y tendrás que volver a iniciar sesión.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="confirmLogout()">Sí, Cerrar Sesión</button>
      </div>
    </div>
  </div>
</div> 