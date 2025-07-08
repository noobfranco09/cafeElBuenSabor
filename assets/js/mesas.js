// logica para los botones de editar de la tabla de mesas
document.querySelectorAll(".btnEditar").forEach(editarMesa => {
editarMesa.addEventListener('click',function(){

    const id = this.dataset.id;
    const numero = this.dataset.numero;
    const estado = this.dataset.estado;

    document.querySelector("#idMesaEditar").value = id;
    document.querySelector("#numeroMesaEditar").value = numero;
    document.querySelector("#estadoMesaEditar").value = estado;

})
})

// logica para los botones de desactivar de la tabla de mesas
document.querySelectorAll(".btnDesactivar").forEach(desactivarMesa => {
desactivarMesa.addEventListener('click',function(){

    const idMesa = this.dataset.id;
    const numero = this.dataset.numero;

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Quieres Desactivar la mesa " + numero + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#A67B5B",
        cancelButtonColor: "#B0B0B0",
        confirmButtonText: "Desactivar!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            fetch('../controller/desactivarMesa.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({idMesa: idMesa})
            })
            .then(response => response.json())
            .then(data => {

                setTimeout(function() {
                    location.reload();
                }, 300); // Espera 0.3 segundos antes de recargar

            })
                    
        }
    });

})
})
