let editarProducto = document.querySelector("#editarProducto");
let idProducto = editarProducto.getAttribute("data-id");
editarProducto.addEventListener("click", () => llenarFormulario(idProducto));
async function llenarFormulario(idProducto) {
  try {
    //obtener el producto usando ajax
    const obtenerProducto= await fetch(`/cafeElBuenSabor/functions/obtenerProducto.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ idProducto: idProducto }),
    });
    const resObtenerProducto=await obtenerProducto.json();

    document.querySelector("#editarIdProducto").value = idProducto;
    document.querySelector("#editarNombre").value = resObtenerProducto.nombre;
    document.querySelector("#editarDescripcion").value = resObtenerProducto.descripcion;
    document.querySelector("#editarPrecio").value = resObtenerProducto.precio;
    document.querySelector("#editarStock").value = resObtenerProducto.stock;

    let select = document.querySelector("#editarCategoria");
    select.setAttribute("name", "idCategoria");
    const categorias =await fetch(
      '/cafeElBuenSabor/functions/obtenerCategorias.php'
    );
    const resCategorias = await categorias.json();
    await resCategorias.forEach((categoria) => {
        console.log(categoria)
      let option = document.createElement("option");
      option.setAttribute("value", `${categoria.idCategoria}`);
      option.appendChild(document.createTextNode(`${categoria.nombre}`));
      select.appendChild(option);
    });
  } catch (error) {
    console.log(error);
  }
}
