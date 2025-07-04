
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawJugadoresPorPais);

    function drawJugadoresPorPais() {

    const data = google.visualization.arrayToDataTable(window.datosGraficoPorPais);

    var options = {
    title: 'Cantidad de jugadores por país',
    chartArea: {width: '60%'},
    hAxis: {
        title: 'Cantidad',
    minValue: 0
},

        legend: 'none'

};

    var chart = new google.visualization.BarChart(document.getElementById('grafico-por-pais'));
    chart.draw(data, options);
}

