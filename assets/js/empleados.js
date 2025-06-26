

const btnAgregar = document.querySelector("#btnAgregar");
const mdlAgregar = new bootstrap.Modal(document.getElementById('mdlAgregar'));
btnAgregar.addEventListener('click',abrirModal)
function abrirModal(){
    mdlAgregar.show();
    
}

document.querySelectorAll(".btnDesactivar").forEach(btn=>{
    btn.addEventListener('click',()=>{
        let idUsuario = btn.getAttribute('data-id');

        Swal.fire({
            title: "Estas seguro?",
            text: "Vas a desactivar al Id: "+idUsuario+"!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#A67B5B",
            cancelButtonColor: "#B0B0B0",
            confirmButtonText: "Desactivar!"
        }).then((result) => {
        if (result.isConfirmed) {
            desactivarUsuario(idUsuario);
            Swal.fire({
            title: "Desactivado!",
            text: "El usuario ah sido desactivado.",
            icon: "success"
            });
            location.reload();
        }
        });
        


    })
});

function desactivarUsuario(id){
    fetch('../../controller/desactivarEmpleado.php',{
        method:"POST",
        headers:{
            'Content-Type':"application/json"
        },
        body:JSON.stringify({idUsuario:id})
    })
    .then(response => response.json())
    .then(data =>{
        
    })


}


