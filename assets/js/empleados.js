const btnAgregar = document.querySelector("#btnAgregar");
const mdlAgregar = new bootstrap.Modal(document.getElementById('mdlAgregar'))

btnAgregar.addEventListener('click',abrirModal)

function abrirModal(){
    mdlAgregar.show();
    
}