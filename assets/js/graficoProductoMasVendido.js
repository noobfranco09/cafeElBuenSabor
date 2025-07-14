// Gráfico de Productos Más Vendidos con diseño mejorado
fetch('../functions/graficoProductoMasVendido.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de productos más vendidos:', data);
    
    const labels = data.map(item => item.nombre);
    const valores = data.map(item => item.cantidadProductos);

    const ctx = document.getElementById('productoMasVendido').getContext('2d');
    
    // Generar colores aleatorios bien distribuidos para distinguir cada barra
    function generateDistinctColors(count) {
        const colors = [];
        const step = 360 / count;
        for (let i = 0; i < count; i++) {
            const hue = Math.round(i * step + Math.random() * step * 0.3) % 360;
            const sat = 65 + Math.floor(Math.random() * 20); // 65-85%
            const lum = 50 + Math.floor(Math.random() * 15); // 50-65%
            colors.push(`hsl(${hue}, ${sat}%, ${lum}%)`);
        }
        // Barajar para evitar agrupación de tonos similares
        for (let i = colors.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [colors[i], colors[j]] = [colors[j], colors[i]];
        }
        return colors;
    }
    const colors = generateDistinctColors(labels.length);
    // Definir hoverColors para evitar error
    const hoverColors = labels.map(() => '#FFD700');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad Vendida',
                data: valores,
                backgroundColor: colors,
                borderColor: '#8B4513',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
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