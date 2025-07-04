
    var map = L.map('map').setView([-34.6037, -58.3816], 4);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

    var marker;


    map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    if (marker) {
    marker.setLatLng([lat, lng]);
} else {
    marker = L.marker([lat, lng]).addTo(map);
}

    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
});

