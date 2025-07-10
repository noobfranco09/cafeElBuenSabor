// logica para mostrar la informacion detallada de esa venta
document.addEventListener("DOMContentLoaded", () => {

    // se realiza esto para poder obtener el id del data-id de los botones
  const botones = document.querySelectorAll('.btnVista');

  botones.forEach(boton => {
    boton.addEventListener('click', () => {
      const idVenta = boton.dataset.id;

      mostrarInformacion(idVenta);
    });
  });
  
});

// funcion para traer la informacion
function mostrarInformacion(idVenta)
{

    const informacionPedido = document.querySelector("#informacionPedido");
    informacionPedido.innerHTML = '';

    fetch('../functions/traerInformacionVenta.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({idVenta: idVenta})
    })
    .then(response => response.json())
    .then((informacion) => {

        // formato para convertir el precio en pesos colombianos
        const formatoCOP = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
        });

        console.log(informacion);

        informacion.forEach((datos) => {
            
            const tr = document.createElement("tr");

            const tdIdPedido = document.createElement("td");
            const tdFecha = document.createElement("td");
            const tdTotal = document.createElement("td");
            const tdPrecioProducto = document.createElement("td");
            const tdNumeroMesa = document.createElement("td");
            const tdNombreProducto = document.createElement("td");
            const tdCantidadProducto = document.createElement("td");
            const tdNota = document.createElement("td");

            tdIdPedido.textContent = datos['pedidos_idPedido'];
            tdFecha.textContent = datos['fecha'];
            tdTotal.textContent =  formatoCOP.format(datos['total']);
            tdNumeroMesa.textContent = datos['numero'];
            tdNombreProducto.textContent = datos['nombre'];
            tdCantidadProducto.textContent = datos['cantidad'];
            tdNota.textContent = datos['nota'];
            tdPrecioProducto.textContent = formatoCOP.format(datos['precioVenta']);
            
            tr.append(tdIdPedido, tdNumeroMesa, tdNombreProducto, tdPrecioProducto, tdCantidadProducto, tdNota, tdTotal);
            informacionPedido.appendChild(tr);

        });

    })
    .catch(error => console.error("Error al traer información:", error));

};