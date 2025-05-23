
    const ctx = document.getElementById('weeklyAppointmentsChart').getContext('2d');

    const weeklyAppointmentsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            datasets: [{
                label: 'Citas agendadas',
                data: [5, 7, 3, 8, 6, 4, 2], // Datos de ejemplo
                borderColor: '#6a1b9a',
                backgroundColor: 'rgba(106, 27, 154, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6a1b9a'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad de citas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Días de la semana'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
