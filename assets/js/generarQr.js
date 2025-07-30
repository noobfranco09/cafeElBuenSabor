const btnGenerarQr = document.querySelectorAll(".btnMostrarQr");
const btnLiberarQr = document.querySelectorAll(".btnLiberarQr");
const mdlVerQr = new bootstrap.Modal(document.getElementById('mdlVerQr'));


document.getElementById("mdlVerQr").addEventListener('hidden.bs.modal', function () {
        location.reload();
    });
btnGenerarQr.forEach(function(boton){
    boton.addEventListener('click',function(){
        let idMesa = boton.getAttribute("data-id");
        let numero = boton.getAttribute("data-numero")
        console.log(numero);
        generarQr(idMesa,numero);

        
        
    });
})


btnLiberarQr.forEach(function(boton){
    boton.addEventListener('click',function(){
        let idMesa = boton.getAttribute("data-id");
        reactivarQr(idMesa);
    });
})


function reactivarQr(idMesa) {
    fetch("/cafeElBuenSabor/functions/reactivarQr.php", {
        method:"POST",
        headers:{
             'Content-Type':"application/json"
        },
        body:JSON.stringify({idMesa:idMesa})
    })
        .then(response => response.json())
        .then(data => {
            if (data.success == "true") {
                Swal.fire({
                title: "Mesa liberada",
                text: "Bien!",
                icon: "success"
                });
            }

            setTimeout(function() {
                    location.reload();
                }, 1000); 
        })
}

function generarQr(mesa,numero){
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
            let nro = numero;
            
            mostrarQr(ruta,mesa,nro);
        }
    });

}


function mostrarQr(ruta,mesa,numero){


const mdlQr = document.querySelector("#mdlBody");
mdlQr.innerHTML = '';   
let imgQr = document.createElement("img");
imgQr.setAttribute('src',ruta);


let lblMesa = document.createElement('h4');
lblMesa.innerText = `Mesa Nro: ${numero}`;
lblMesa.classList.add("text-center");
mdlQr.appendChild(lblMesa);
let container = document.createElement("div");
container.classList.add("qr-container");

container.appendChild(imgQr);
mdlQr.appendChild(container);

mdlVerQr.show();

    

}