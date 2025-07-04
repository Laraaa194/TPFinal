
const lat = window.usuarioCoords && !isNaN(window.usuarioCoords.lat) ? parseFloat(window.usuarioCoords.lat) : -34.6037;
const lng = window.usuarioCoords && !isNaN(window.usuarioCoords.lng) ? parseFloat(window.usuarioCoords.lng) : -58.3816;

var map = L.map('map', {
    center: [lat, lng],
    zoom: 15,
    zoomControl: true,
    dragging: false,
    scrollWheelZoom: false,
    doubleClickZoom: false,
    boxZoom: false,
    keyboard: false,
    tap: false
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.marker([lat, lng]).addTo(map);
