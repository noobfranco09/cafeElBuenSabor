// Funcionalidad para editar categorías
document.querySelectorAll(".btnEditar").forEach(editarCategoria => {
editarCategoria.addEventListener('click',function(){

    const id = this.dataset.id;
    const nombre = this.dataset.nombre;
    const descripcion = this.dataset.descripcion;
    const estado = this.dataset.estado;

    document.querySelector("#idCategoriaEditar").value = id;
    document.querySelector("#nombreCategoriaEditar").value = nombre;
    document.querySelector("#descripcionCategoriaEditar").value = descripcion;
    document.querySelector("#estadoCategoriaEditar").value = estado;

})
})

// logica para los botones de eliminar de la tabla de roles
document.querySelectorAll(".btnDesactivar").forEach(desactivarCategoria => {
desactivarCategoria.addEventListener('click',function(){

    const id = this.dataset.id;
    const nombre = this.dataset.nombre;

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Quieres desactivar la categoria " + nombre + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#A67B5B",
        cancelButtonColor: "#B0B0B0",
        confirmButtonText: "Desactivar!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            fetch('../controller/desactivarCategoria.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({idCategoria: id})
            })
            .then(response => response.json())
            .then(data => {

                setTimeout(function() {
                    location.reload();
                }, 500); // Espera 0.5 segundos antes de recargar

            })
                    
        }
    });

})
})