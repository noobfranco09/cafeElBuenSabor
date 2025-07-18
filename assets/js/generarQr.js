const btnGenerarQr = document.querySelectorAll(".btnMostrarQr");
const mdlVerQr = new bootstrap.Modal(document.getElementById('mdlVerQr'));

btnGenerarQr.forEach(function(boton){
    boton.addEventListener('click',function(){
        let idMesa = boton.getAttribute("data-id");
        generarQr(idMesa);

        
        
    });
})

function generarQr(mesa){
    fetch("/cafeElBuenSabor/controller/crearQr.php",{
        method:"POST",
        headers:{
             'Content-Type':"application/json"
        },
        body:JSON.stringify({idMesa:mesa})
    })
    .then(response => response.json())
    .then(data =>{
        if(data.data=="Ocurrio un error"){
            
        }else{
            let ruta = data.data;
            let mesa = data.mesa
            
            mostrarQr(ruta,mesa);
        }
    });

}


function mostrarQr(ruta,mesa){


const mdlQr = document.querySelector("#mdlBody");
mdlQr.innerHTML = '';   
let imgQr = document.createElement("img");
imgQr.setAttribute('src',ruta);


let lblMesa = document.createElement('h4');
lblMesa.innerText = `Mesa Id: ${mesa}`;
lblMesa.classList.add("text-center");
mdlQr.appendChild(lblMesa);
let container = document.createElement("div");
container.classList.add("qr-container");

container.appendChild(imgQr);
mdlQr.appendChild(container);

mdlVerQr.show();


}