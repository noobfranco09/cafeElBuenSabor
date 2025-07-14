

const btnAgregar = document.querySelector("#btnAgregar");

btnAgregar.addEventListener('click',abrirModal)
function abrirModal(){
    const mdlAgregar = new bootstrap.Modal(document.getElementById('mdlAgregar'));
    mdlAgregar.show();
    
}


document.querySelector("#tablaUsuarios").addEventListener("click", function (e) {
    const boton = e.target.closest(".btnDesactivar");
    if (boton) {
        let idUsuario = boton.getAttribute("data-id");
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Vas a desactivar al ID: " + idUsuario + "!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#A67B5B",
            cancelButtonColor: "#B0B0B0",
            confirmButtonText: "¡Desactivar!"
        }).then((result) => {
            if (result.isConfirmed) {
                desactivarUsuario(idUsuario);
                
            }
        });
    }
});



    

function desactivarUsuario(id){
    fetch('/cafeElBuenSabor/controller/desactivarEmpleado.php',{
        method:"POST",
        headers:{
            'Content-Type':"application/json"
        },
        body:JSON.stringify({idUsuario:id})
    })
    .then(response => response.json())
    .then(data =>{
         Swal.fire({
                    title: "Desactivado!",
                    text: "El usuario ah sido desactivado.",
                    icon: "success"
                    });
                    setTimeout(()=>{
                        location.reload();
                    },1000)
                
    })


}



document.querySelector("#tablaUsuarios").addEventListener("click", function (e) {
    const boton = e.target.closest(".btnEditar");
    if (boton) {
        let id = boton.getAttribute("data-id");
        obtenerUsuario(id);
    }
});

function obtenerUsuario(id){
    fetch('/cafeElBuenSabor/functions/obtenerUsuario.php',{
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
    const prpMdlEditar = document.getElementById('mdlEditar');
    let id = usuario.idUsuario;
    let nombre = usuario.nombre;
    let fecha = usuario.fechaIngreso;
    let telefono = usuario.telefono;
    let correo = usuario.correo;
    let rol = usuario.idRoll
    let contraseña = usuario.contraseña
    let estado = usuario.estado;    

    
    const inputId = prpMdlEditar.querySelector("#idUsuario").value=id;
    const inputNombre = prpMdlEditar.querySelector("#nombreEditar").value=nombre;
    const inputfecha = prpMdlEditar.querySelector("#fechaEditar").value=fecha;
    const inputtelefono = prpMdlEditar.querySelector("#telefonoEditar").value=telefono;
    const inputCorreo = prpMdlEditar.querySelector("#correoEditar").value=correo;
    const iptRol = prpMdlEditar.querySelector("#rolEditar").value=rol;
    const inputContraseña = prpMdlEditar.querySelector("#contraseñaEditar").value=contraseña;   
    const sltEstado = prpMdlEditar.querySelector("#estadoEditar").value=estado;
    console.log(rol);
    mdlEditar.show();
    

    
}