google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    if (!window.datosGraficoSexo) {
        console.error('No hay datos para el gráfico');
        return;
    }

    const data = google.visualization.arrayToDataTable(window.datosGraficoSexo);

    const options = {
        // title: 'Cantidad de usuarios por sexo',
        curveType: 'function',
        legend: { position: 'absolute' },
        width: '100%',
        height: 300,
    };

    const chart = new google.visualization.PieChart(document.getElementById('grafico-sexo'));
    chart.draw(data, options);
}