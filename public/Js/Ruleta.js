document.addEventListener("DOMContentLoaded", () => {
    // === BOTÓN SALIR ===
    const btnSalir = document.getElementById('btnSalir');
    const modalElement = document.getElementById('confirmSalirModal');

    if (btnSalir && modalElement) {
        const salirModal = new bootstrap.Modal(modalElement);
        btnSalir.addEventListener('click', (e) => {
            e.preventDefault();
            salirModal.show();
        });
    }


    const categoriaElegida = document.getElementById("categoria-data")?.dataset.categoria;
    const playBtn = document.querySelector(".play-btn");
    if (!playBtn || !categoriaElegida) return;

    playBtn.addEventListener("click", function () {
        playBtn.disabled = true;
        const categories = ['cat1', 'cat2', 'cat3', 'cat4', 'cat5', 'cat6'];
        const categoryMap = {
            cat1: 'ciencia',
            cat2: 'deporte',
            cat3: 'geografia',
            cat4: 'arte',
            cat5: 'historia',
            cat6: 'entretenimiento'
        };

        const finalCatId = Object.keys(categoryMap).find(key => categoryMap[key] === categoriaElegida);
        const finalIndex = categories.indexOf(finalCatId);

        const totalCycles = 3;
        const totalSteps = totalCycles * categories.length + finalIndex;

        let index = 0;

        const interval = setInterval(() => {
            categories.forEach(id => document.getElementById(id)?.classList.remove('active'));

            const currentId = categories[index % categories.length];
            document.getElementById(currentId)?.classList.add('active');

            if (index === totalSteps) {
                clearInterval(interval);

                // Esperar 3 segundos luego de detenerse
                setTimeout(() => {
                    window.location.href = "/TPFinal/Pregunta/showPregunta";
                }, 500); // antes tenías 1000 ms, que es 1 segundo
            }

            index++;
        }, 100);
    });
});
