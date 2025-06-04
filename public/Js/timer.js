let tiempoRestante = 10; // segundos
const contadorElemento = document.getElementById('contador-tiempo');

const intervalo = setInterval(() => {
    tiempoRestante--;
    if (contadorElemento) {
        contadorElemento.textContent = tiempoRestante.toString();
    }

    if (tiempoRestante <= 0) {
        clearInterval(intervalo);
        // Redirigir automáticamente a Resultado, indicando timeout
        window.location.href = '/TPFinal/Resultado/show?timeout=1';
    }
}, 1000);
