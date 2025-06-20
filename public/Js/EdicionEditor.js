document.addEventListener("DOMContentLoaded", () => {

    const btnEliminar = document.getElementById('btn-eliminar');
    const modalElement = document.getElementById('confirmEliminarModal');

    if (btnEliminar && modalElement) {
        const eliminarModal = new bootstrap.Modal(modalElement);
        btnEliminar.addEventListener('click', (e) => {
            e.preventDefault();
            eliminarModal.show();
        });
    }
});