google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    if (!window.datosGraficoRespuestas) {
        console.error('No hay datos para el gráfico');
        return;
    }

    const data = google.visualization.arrayToDataTable(window.datosGraficoRespuestas);

    const options = {
        // title: 'Cantidad de usuarios por sexo',
        curveType: 'function',
        legend: { position: 'absolute' },
        width: '100%',
        height: 300,
        pieHole: 0.4,
    };

    const chart = new google.visualization.PieChart(document.getElementById('grafico-respuestas'));
    chart.draw(data, options);
}