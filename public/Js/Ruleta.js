document.addEventListener("DOMContentLoaded", () => {
    const categoriaElegida = document.getElementById("categoria-data")?.dataset.categoria;
    const playBtn = document.querySelector(".play-btn");
    if (!playBtn) return;

    playBtn.addEventListener("click", function () {
        const categories = ['cat1', 'cat2', 'cat3', 'cat4', 'cat5', 'cat6'];
        const categoryMap = {
            cat1: 'ciencia',
            cat2: 'deporte',
            cat3: 'geografia',
            cat4: 'arte',
            cat5: 'historia',
            cat6: 'entretenimiento'
        };

        // Buscar el ID (catX) que corresponde a la categoría elegida por PHP
        const finalCatId = Object.keys(categoryMap).find(key => categoryMap[key] === categoriaElegida);

        let index = 0;
        let totalCycles = 3; // más controlado
        let totalSteps = totalCycles * categories.length;

        // Buscamos cuántos pasos faltan hasta caer en la categoría correcta
        const finalIndex = categories.indexOf(finalCatId);
        totalSteps += finalIndex;

        let interval = setInterval(() => {
            categories.forEach(id => document.getElementById(id)?.classList.remove('active'));

            const currentId = categories[index % categories.length];
            document.getElementById(currentId)?.classList.add('active');

            index++;

            if (index >= totalSteps) {
                clearInterval(interval);

                // Redirigir sin enviar categoría en la URL
                window.location.href = "/TPFinal/Partida/pregunta";
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
