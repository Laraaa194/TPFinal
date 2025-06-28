google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChartPreguntas);

function drawChartPreguntas(tipo = 'categoria') {
    let datos;
    let titulo;

    if (tipo === 'categoria') {
        datos = google.visualization.arrayToDataTable(window.datosPreguntasPorCategoria);
    } else {
        datos = google.visualization.arrayToDataTable(window.datosPreguntasPorDificultad);

    }

    const options = {
        title: titulo,
        legend: { position: 'none' },
        hAxis: { title: tipo.charAt(0).toUpperCase() + tipo.slice(1) },
        vAxis: { title: 'Cantidad' },
        colors: ['#4CAF50'],
        width: '100%',
        height: 300
    };

    const chart = new google.visualization.ColumnChart(document.getElementById('grafico-preguntas'));
    chart.draw(datos, options);
}

// Cambiar gráfico al seleccionar otra opción
document.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('selector-tipo');
    selector.addEventListener('change', function () {
        drawChartPreguntas(this.value);
    });
});