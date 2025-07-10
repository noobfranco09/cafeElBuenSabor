// Gráfico de Mesas Atendidas por Mesero con diseño mejorado
fetch('../functions/graficoMesasPorMesero.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de mesas por mesero:', data);
    
    const labels = data.map(item => item.numero);
    const valores = data.map(item => item.cantidadMesasAtendidas);

    const ctx = document.getElementById('mesasPorMesero').getContext('2d');
    
    // Colores temáticos del café
    const colors = [
        'rgba(139, 69, 19, 0.8)',   // Marrón café
        'rgba(160, 82, 45, 0.8)',   // Marrón sienna
        'rgba(205, 133, 63, 0.8)',  // Marrón peru
        'rgba(210, 180, 140, 0.8)', // Marrón trigo
        'rgba(244, 164, 96, 0.8)',  // Marrón arena
        'rgba(255, 215, 0, 0.8)'    // Dorado
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Mesas Atendidas',
                data: valores,
                backgroundColor: colors,
                borderColor: '#8B4513',
                borderWidth: 3,
                hoverBackgroundColor: '#FFD700',
                hoverBorderColor: '#8B4513',
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: '#8B4513',
                        font: {
                            family: 'Arial, sans-serif',
                            size: 12,
                            weight: 'bold'
                        },
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(139, 69, 19, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#FFD700',
                    borderWidth: 2,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' mesas (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart',
                animateRotate: true,
                animateScale: true
            },
            cutout: '60%',
            radius: '90%'
        }
    });
})
.catch(error => {
    console.error('Error al cargar los datos de mesas por mesero:', error);
    // Mostrar mensaje de error en el canvas
    const canvas = document.getElementById('mesasPorMesero');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#8B4513';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Error al cargar datos', canvas.width / 2, canvas.height / 2);
});