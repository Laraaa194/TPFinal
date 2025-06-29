google.charts.setOnLoadCallback(drawPreguntasCreadas);

function drawPreguntasCreadas() {
    if (!window.datosPreguntasCreadas) {
        console.error("No hay datos para preguntas creadas");
        return;
    }

    const data = google.visualization.arrayToDataTable(window.datosPreguntasCreadas);

    const options = {
        title: 'Preguntas creadas por categoría',
        legend: {
            position: 'top',
            textStyle: {
                fontSize: 12,   // Tamaño de letra para la leyenda
                bold: true,
            }
        },
        hAxis: {
            title: 'Categoría',
            textStyle: { fontSize: 12 },

        },
        vAxis: {
            title: 'Cantidad',
            textStyle: { fontSize: 14 },
            format: '0',          // Formatea para mostrar solo enteros
            viewWindowMode: 'explicit',
            viewWindow: {
                min: 0
            },
            gridlines: {
                count: -1        // Para que Google calcule automáticamente
            },
            minorGridlines: {
                count: 0         // Quita líneas de división menores
            }

        },
        colors: ['#28a745', '#ff6600'], // Verde para editor, naranja para jugador
        height: 300,
        width: '100%',

    };

    console.log(window.datosPreguntasCreadas);
    const chart = new google.visualization.ColumnChart(document.getElementById('grafico-preguntas-creadas'));
    chart.draw(data, options);


}