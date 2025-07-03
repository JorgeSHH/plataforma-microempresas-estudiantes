// Función para manejar la acción de Aceptar
function handleAceptar(idRequest, idJob, idCompany, idStudent) {
    Swal.fire({
        

        title: '¿Estás seguro de aceptar?',
        text: `Se aceptará la solicitud con ID: ${idRequest}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aceptar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes añadir la lógica para enviar la solicitud de aceptación al servidor
            // Por ejemplo, usando fetch() o XMLHttpRequest
            console.log('Aceptar solicitud:', { idRequest, idJob, idCompany, idStudent });
            Swal.fire(
                '¡Aceptado!',
                'La solicitud ha sido aceptada.',
                'success'
            );
        }
    });
}

// Función para manejar la acción de Rechazar
function handleRechazar(idRequest, idJob, idCompany, idStudent) {
    Swal.fire({
        title: '¿Estás seguro de rechazar?',
        text: `Se rechazará la solicitud con ID: ${idRequest}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, rechazar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes añadir la lógica para enviar la solicitud de rechazo al servidor
            console.log('Rechazar solicitud:', { idRequest, idJob, idCompany, idStudent });
            Swal.fire(
                '¡Rechazado!',
                'La solicitud ha sido rechazada.',
                'error'
            );
        }
    });
}

// Función para manejar la acción de Ver
function handleVer(idRequest, idJob, idCompany, idStudent) {
    Swal.fire({
        title: 'Detalles de la Solicitud',
        html: `
            <p><strong>ID Solicitud:</strong> ${idRequest}</p>
            <p><strong>ID Trabajo:</strong> ${idJob}</p>
            <p><strong>ID Compañía:</strong> ${idCompany}</p>
            <p><strong>ID Estudiante:</strong> ${idStudent}</p>
            <p>Aquí podrías redirigir a una página de perfil o mostrar más detalles.</p>
        `,
        icon: 'info',
        confirmButtonText: 'Cerrar'
    });
    console.log('Ver detalles:', { idRequest, idJob, idCompany, idStudent });
    // Aquí puedes añadir la lógica para redirigir a una página de detalles
    // window.location.href = `perfil_estudiante.php?id=${idStudent}`;
}

// Función para manejar la acción de Calificar
function handleCalificar(idRequest, idJob, idCompany, idStudent) {
    Swal.fire({
        title: 'Calificar Solicitud',
        html: `
            <p>Vas a calificar la solicitud con ID: ${idRequest}.</p>
            <input type="number" id="rating" class="swal2-input" placeholder="Ingresa una calificación (1-5)" min="1" max="5">
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Enviar Calificación',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const rating = Swal.getPopup().querySelector('#rating').value;
            if (!rating || rating < 1 || rating > 5) {
                Swal.showValidationMessage(`Por favor, ingresa una calificación válida (1-5)`);
            }
            return rating;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const ratingValue = result.value;
            // Aquí puedes añadir la lógica para enviar la calificación al servidor
            console.log('Calificar solicitud:', { idRequest, idJob, idCompany, idStudent, rating: ratingValue });
            Swal.fire(
                '¡Calificado!',
                `Has calificado la solicitud con ${ratingValue} estrellas.`,
                'success'
            );
        }
    });
}

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    // Seleccionar todos los botones de acción
    const actionButtons = document.querySelectorAll(
        '.contract-actions button[data-action]'
    );
    const viewButtons = document.querySelectorAll(
        '.contract-item button[data-action="verPerfil"]'
    );

    // Unir ambas NodeLists para iterar sobre todos los botones relevantes
    const allButtons = [...actionButtons, ...viewButtons];

    allButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Obtener el tipo de acción del data-attribute
            const action = this.dataset.action;

            // Obtener los IDs de los data-attributes
            const idRequest = this.dataset.idRequest;
            const idJob = this.dataset.idJob;
            const idCompany = this.dataset.idCompany;
            const idStudent = this.dataset.idStudent;

            // Llamar a la función correspondiente según la acción
            switch (action) {
                case 'aceptar':
                    handleAceptar(idRequest, idJob, idCompany, idStudent);
                    break;
                case 'rechazar':
                    handleRechazar(idRequest, idJob, idCompany, idStudent);
                    break;
                case 'verPerfil':
                    handleVer(idRequest, idJob, idCompany, idStudent);
                    break;
                case 'calificar':
                    handleCalificar(idRequest, idJob, idCompany, idStudent);
                    break;
                default:
                    console.warn('Acción no reconocida:', action);
            }
        });
    });
});


// hello my name is assistant