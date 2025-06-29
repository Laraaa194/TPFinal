document.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('selector-fecha-filtro');
    if (!selector) {
        console.error('No se encontró el selector');
        return;
    }

    selector.addEventListener('change', function () {
        const filtro = this.value;
        cargarYdibujarPartidas(filtro);
        cargarYdibujarUsuariosNuevos(filtro); // <-- agregás esta línea
    });

    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(() => {
        const filtroInicial = selector.value;
        cargarYdibujarPartidas(filtroInicial);
        cargarYdibujarUsuariosNuevos(filtroInicial); // <-- también al cargar por primera vez
    });
});
function cargarYdibujarPartidas(filtro) {
    fetch(`/LobbyAdmin/getPartidasPor?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
            const dataTable = google.visualization.arrayToDataTable(data);
            const chart = new google.visualization.ColumnChart(document.getElementById('grafico-partidas'));
            chart.draw(dataTable, {
                title: 'Total de partidas jugadas',
                hAxis: {title: filtro.charAt(0).toUpperCase() + filtro.slice(1)},
                vAxis: {title: 'Cantidad', format: '0'},
                colors: ['#007bff'],
                height: 300
            });
        });
}

function cargarYdibujarUsuariosNuevos(filtro) {
    fetch(`/LobbyAdmin/getUsuariosNuevosPor?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
            console.log('Usuarios nuevos:', data);
            const dataTable = google.visualization.arrayToDataTable(data);
            const chart = new google.visualization.ColumnChart(document.getElementById('grafico-usuarios-nuevos'));
            chart.draw(dataTable, {
                title: 'Usuarios nuevos',
                hAxis: {title: filtro.charAt(0).toUpperCase() + filtro.slice(1)},
                vAxis: {title: 'Cantidad', format: '0'},
                colors: ['#28a745'],
                height: 300
            });
        });
}
