google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    if (!window.datosGraficoEdad) {
        console.error('No hay datos para el gráfico');
        return;
    }

    const data = google.visualization.arrayToDataTable(window.datosGraficoEdad);

    const options = {
        // title: 'Cantidad de usuarios por sexo',
        curveType: 'function',
        legend: { position: 'absolute' },
        width: '100%',
        height: 300,
    };

    const chart = new google.visualization.PieChart(document.getElementById('grafico-edad'));
    chart.draw(data, options);
}