// logica para los botones de editar de la tabla de roles
document.querySelectorAll(".btnEditar").forEach(editarRol => {
editarRol.addEventListener('click',function(){

    const id = this.dataset.id;
    const nombre = this.dataset.nombre;
    const descripcion = this.dataset.descripcion;

    document.querySelector("#idRolEditar").value = id;
    document.querySelector("#nombreRolEditar").value = nombre;
    document.querySelector("#descripcionRolEditar").value = descripcion;

})
})

// logica para los botones de eliminar de la tabla de roles
document.querySelectorAll(".btnEliminar").forEach(eliminarRol => {
eliminarRol.addEventListener('click',function(){

    const idRoll = this.dataset.id;
    const nombreRol = this.dataset.nombre;

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Quieres eliminar el rol de " + nombreRol + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#A67B5B",
        cancelButtonColor: "#B0B0B0",
        confirmButtonText: "Eliminar!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            fetch('../controller/eliminarRol.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({idRoll: idRoll})
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "¡Eliminado con éxito!",
                    text: data.message,
                    icon: "success"
                });

                // se elimina de la vista del DOM para no tener que recargar la pagina
                eliminarRol.closest("tr").remove();

            })
                    
        }
    });

})
})