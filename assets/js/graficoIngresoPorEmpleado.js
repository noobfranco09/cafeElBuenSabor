// Gráfico de Ingresos por Empleado con diseño mejorado
fetch('../functions/graficoIngresoPorEmpleado.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de ingresos por empleado:', data);
    
    const labels = data.map(item => item.nombre);
    const valores = data.map(item => item.ingresoPorEmpelado);

    const ctx = document.getElementById('ingresoPorEmpleado').getContext('2d');
    
    // Crear gradientes para las barras
    const gradients = valores.map((_, index) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(139, 69, 19, 0.9)'); // Marrón café
        gradient.addColorStop(1, 'rgba(160, 82, 45, 0.7)'); // Marrón sienna
        return gradient;
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos por Empleado',
                data: valores,
                backgroundColor: gradients,
                borderColor: '#8B4513',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: '#FFD700',
                hoverBorderColor: '#8B4513',
                hoverBorderWidth: 3
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
                            size: 12
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
    console.error('Error al cargar los datos de ingresos por empleado:', error);
    // Mostrar mensaje de error en el canvas
    const canvas = document.getElementById('ingresoPorEmpleado');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#8B4513';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Error al cargar datos', canvas.width / 2, canvas.height / 2);
});