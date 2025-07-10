let editarProducto = document.querySelector("#editarProducto");
let idProducto = editarProducto.getAttribute("data-id");
editarProducto.addEventListener("click", ()=> llenarFormulario(idProducto));
function llenarFormulario(idProducto) {
    fetch(`../../functions/obtenerProducto.php`, {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({idProducto:idProducto})
  })
    .then((res) => res.json())
      .then((res) => {
          console.log(res)
      document.querySelector("#editarNombre").value = res.nombre;
      document.querySelector("#editarDescripcion").value = res.descripcion;
      document.querySelector("#editarPrecio").value = res.precio;
      document.querySelector("#editarStock").value = res.stock;
    });
}
