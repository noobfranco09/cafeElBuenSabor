

const btnAgregar = document.querySelector("#btnAgregar");

btnAgregar.addEventListener('click',abrirModal)
function abrirModal(){
    const mdlAgregar = new bootstrap.Modal(document.getElementById('mdlAgregar'));
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



document.querySelectorAll(".btnEditar").forEach(btn=>{
    btn.addEventListener('click',()=>{
        let id = btn.getAttribute('data-id');
        obtenerUsuario(id)
    
    });
});

function obtenerUsuario(id){
    fetch('../../functions/obtenerUsuario.php',{
        method:"POST",
        headers:{
            'Content-Type':"application/json"
        },
        body:JSON.stringify({idUsuario:id})
    })
    .then(response => response.json())
    .then(data=>{
        let usuario = data.datosUsuario
        llenarModal(usuario);
    });
}

function llenarModal(usuario){
    const mdlEditar = new bootstrap.Modal(document.getElementById('mdlEditar'));
    let id = usuario.idUsuario;
    let nombre = usuario.nombre;
    let fecha = usuario.fechaIngreso;
    let telefono = usuario.telefono;
    let correo = usuario.correo;
    let rol = usuario.rol
    let contraseña = usuario.contraseña
    let estado = usuario.estado;    

    

    
}