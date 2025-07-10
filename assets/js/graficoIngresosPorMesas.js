// Gráfico de Ingresos por Mesas con diseño mejorado
fetch('../functions/graficoIngresosPorMesa.php')
.then(response => response.json())
.then(data => {
    console.log('Datos de ingresos por mesas:', data);
    
    const labels = data.map(item => item.numero);
    const valores = data.map(item => item.ingresoMesa);

    const ctx = document.getElementById('ingresoPorMesa').getContext('2d');
    
    // Paleta amplia de colores temáticos del café
    const baseColors = [
        '#8B4513', // Marrón café
        '#A0522D', // Marrón sienna
        '#CD853F', // Marrón peru
        '#D2B48C', // Marrón trigo
        '#F4A460', // Marrón arena
        '#FFD700', // Dorado
        '#DAA520', // Dorado oscuro
        '#B8860B', // Dorado web
        '#6F4E37', // Café oscuro
        '#C19A6B', // Café claro
        '#A67B5B', // Café medio
        '#E6BE8A', // Café suave
        '#BC8F8F', // Café rosado
        '#DEB887', // Café beige
        '#FFE4B5'  // Café muy claro
    ];
    // Asignar colores cíclicamente según la cantidad de datos
    const colors = labels.map((_, i) => baseColors[i % baseColors.length]);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos por Mesa',
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
                            return 'Mesa ' + context.label + ': $' + context.parsed.toLocaleString('es-CO') + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart',
                animateRotate: true,
                animateScale: true
            }
        }
    });
})
.catch(error => {
    console.error('Error al cargar los datos de ingresos por mesas:', error);
    // Mostrar mensaje de error en el canvas
    const canvas = document.getElementById('ingresoPorMesa');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#8B4513';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Error al cargar datos', canvas.width / 2, canvas.height / 2);
});