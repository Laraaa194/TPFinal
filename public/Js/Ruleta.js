document.addEventListener("DOMContentLoaded", () => {
    const playBtn = document.querySelector(".play-btn");
    if (!playBtn) return;

    playBtn.addEventListener("click", function () {
        const categories = ['cat1', 'cat2', 'cat3', 'cat4', 'cat5', 'cat6'];
        let index = 0;
        let totalCycles = Math.floor(Math.random() * 3) + 3;
        let totalSteps = totalCycles * categories.length + Math.floor(Math.random() * categories.length);

        let interval = setInterval(() => {
            categories.forEach(id => document.getElementById(id)?.classList.remove('active'));
            document.getElementById(categories[index % categories.length])?.classList.add('active');

            index++;

            if (index >= totalSteps) {
                clearInterval(interval);
                let selectedId = categories[(index - 1) % categories.length];
                console.log('Categoría seleccionada:', selectedId);
                // Acá podrías redirigir, hacer fetch, etc.
            }
        }, 100);
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const btnSalir = document.getElementById('btnSalir');
    const salirModal = new bootstrap.Modal(document.getElementById('confirmSalirModal'));

    btnSalir.addEventListener('click', function (e) {
        e.preventDefault(); // evita que se envíe o cambie de página
        salirModal.show(); // muestra el modal
    });
});

