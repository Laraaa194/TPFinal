document.addEventListener('DOMContentLoaded', function () {
    // Validación de correo
    const emailInput = document.querySelector('input[name="correo"]');
    const emailErrorDiv = document.createElement('div');
    emailErrorDiv.classList.add('small', 'mt-1', 'fw-bold');
    emailErrorDiv.style.color = '#770202';
    emailInput.insertAdjacentElement('afterend', emailErrorDiv);

    let emailTimeout = null;

    emailInput.addEventListener('input', function () {
        const correo = emailInput.value.trim();

        clearTimeout(emailTimeout);

        if (correo.length < 5) {
            emailErrorDiv.textContent = '';
            return;
        }

        emailTimeout = setTimeout(() => {
            fetch('/Register/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'accion=validarEmail&correo=' + encodeURIComponent(correo)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.existe) {
                        emailErrorDiv.textContent = 'Este correo ya está registrado';
                    } else {
                        emailErrorDiv.textContent = '';
                    }
                })
                .catch(error => {
                    console.error('Error al verificar el correo:', error);
                });
        }, 400);
    });

    // Validación de nombre de usuario
    const usernameInput = document.querySelector('input[name="nombreUsuario"]');
    const usernameErrorDiv = document.createElement('div');
    usernameErrorDiv.classList.add('small', 'mt-1', 'fw-bold');
    usernameErrorDiv.style.color = '#af0719';
    usernameInput.insertAdjacentElement('afterend', usernameErrorDiv);

    let usernameTimeout = null;

    usernameInput.addEventListener('input', function () {
        const nombreUsuario = usernameInput.value.trim();

        clearTimeout(usernameTimeout);

        if (nombreUsuario.length < 3) {
            usernameErrorDiv.textContent = '';
            return;
        }

        usernameTimeout = setTimeout(() => {
            fetch('/Register/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'accion=validarNombreUsuario&nombreUsuario=' + encodeURIComponent(nombreUsuario)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.existe) {
                        usernameErrorDiv.textContent = 'Este nombre de usuario ya está en uso';
                    } else {
                        usernameErrorDiv.textContent = '';
                    }
                })
                .catch(error => {
                    console.error('Error al verificar el nombre de usuario:', error);
                });
        }, 400);
    });
});
