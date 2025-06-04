document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('respuesta-correcta');
    if (el && el.dataset.respuestaCorrecta === "1") {
        const modalCorrecta = new bootstrap.Modal(document.getElementById('modalCorrecta'));
        modalCorrecta.show();
    }
});
