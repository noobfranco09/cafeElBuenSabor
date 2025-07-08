// se raliza el grafico que mostrara los 3 productos mas vendidos
fetch('../functions/graficoProductoMasVendido.php')
.then(response => response.json())
.then(data => {

    console.log(data)
    const labels = data.map(item => item.nombre);
    const valores = data.map(item => item.cantidadProductos);

    const ctx = document.getElementById('productoMasVendido').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Puede ser line, pie, doughnut, etc.
        data: {
            labels: labels,
            datasets: [{
                label: 'Gráfico Productos Mas Vendidos',
                data: valores,
                backgroundColor: 'rgba(192, 75, 124, 0.5)',
                borderColor: 'rgb(192, 75, 91)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})
.catch(error => console.error('Error al cargar los datos:', error));