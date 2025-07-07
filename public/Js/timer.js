const contadorElemento = document.getElementById('contador-tiempo');

function iniciarContador() {
    const ahora = Math.floor(Date.now() / 1000);
    let tiempoRestante = TIEMPO_LIMITE - (ahora - TIEMPO_INICIO);

    if (tiempoRestante < 0) {
        // Ya venció el tiempo, redirigimos de inmediato
        window.location.href = '/Pregunta/verificarRespuesta';
        return;
    }

    contadorElemento.textContent = tiempoRestante.toString();

    const intervalo = setInterval(() => {
        tiempoRestante--;

        if (tiempoRestante < 0) {
            clearInterval(intervalo);
            window.location.href = '/Pregunta/verificarRespuesta';
        } else {
            contadorElemento.textContent = tiempoRestante.toString();
        }
    }, 1000);
}

document.addEventListener("DOMContentLoaded", iniciarContador);
