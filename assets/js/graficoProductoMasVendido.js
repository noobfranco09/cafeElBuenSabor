// Gráfico de Productos Más Vendidos con diseño mejorado
fetch('../functions/graficoProductoMasVendido.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de productos más vendidos:', data);
    
    const labels = data.map(item => item.nombre);
    const valores = data.map(item => item.cantidadProductos);

    const ctx = document.getElementById('productoMasVendido').getContext('2d');
    
    // Crear gradientes para las barras
    const gradients = valores.map((_, index) => {
        const gradient = ctx.createLinearGradient(0, 0, 400, 0);
        gradient.addColorStop(0, 'rgba(139, 69, 19, 0.8)'); // Marrón café
        gradient.addColorStop(1, 'rgba(160, 82, 45, 0.6)'); // Marrón sienna
        return gradient;
    });
    // Array de colores de hover para que solo la barra activa cambie
    const hoverColors = valores.map(() => '#FFD700');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad Vendida',
                data: valores,
                backgroundColor: gradients,
                borderColor: '#8B4513',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: hoverColors,
                hoverBorderColor: '#8B4513',
                hoverBorderWidth: 3,
                minBarLength: 10 // Aumenta el tamaño mínimo de la barra
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Hacer barras horizontales
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#8B4513',
                        font: {
                            family: 'Arial, sans-serif',
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(139, 69, 19, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#FFD700',
                    borderWidth: 2,
                    cornerRadius: 8,
                    displayColors: false,
                    mode: 'nearest',
                    intersect: true,
                    callbacks: {
                        label: function(context) {
                            return 'Vendidos: ' + context.parsed.x + ' unidades';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(139, 69, 19, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#8B4513',
                        font: {
                            family: 'Arial, sans-serif',
                            size: 12
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(139, 69, 19, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#8B4513',
                        font: {
                            family: 'Arial, sans-serif',
                            size: 12
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: true,
                mode: 'nearest'
            }
        }
    });
})
.catch(error => {
    console.error('Error al cargar los datos de productos más vendidos:', error);
    // Mostrar mensaje de error en el canvas
    const canvas = document.getElementById('productoMasVendido');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#8B4513';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Error al cargar datos', canvas.width / 2, canvas.height / 2);
});