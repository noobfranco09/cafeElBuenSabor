// Gráfico de Ingresos por Fecha con diseño mejorado
fetch('../functions/graficoIngresosPorFecha.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de ingresos por fecha:', data);
    
    const labels = data.map(item => item.fechaDia);
    const valores = data.map(item => item.ingresoFecha);

    const ctx = document.getElementById('ingresoPorFecha').getContext('2d');
    
    // Crear gradiente para el gráfico de área
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(139, 69, 19, 0.6)'); // Marrón café
    gradient.addColorStop(1, 'rgba(160, 82, 45, 0.2)'); // Marrón sienna

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos Diarios',
                data: valores,
                backgroundColor: gradient,
                borderColor: '#8B4513',
                borderWidth: 3,
                pointBackgroundColor: '#FFD700',
                pointBorderColor: '#8B4513',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.3,
                pointHoverBackgroundColor: '#FFD700',
                pointHoverBorderColor: '#8B4513'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                    callbacks: {
                        label: function(context) {
                            return 'Ingresos: $' + context.parsed.y.toLocaleString('es-CO');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(139, 69, 19, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#8B4513',
                        font: {
                            family: 'Arial, sans-serif',
                            size: 11
                        },
                        maxRotation: 45
                    }
                },
                y: {
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
                        },
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CO');
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
})
.catch(error => {
    console.error('Error al cargar los datos de ingresos por fecha:', error);
    // Mostrar mensaje de error en el canvas
    const canvas = document.getElementById('ingresoPorFecha');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#8B4513';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Error al cargar datos', canvas.width / 2, canvas.height / 2);
});