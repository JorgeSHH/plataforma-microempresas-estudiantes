// Función para manejar la acción de Aceptar
// Función para manejar la acción de Aceptar
function handleAceptar(idRequest, idJob, idCompany, idStudent) {
    // Datos a enviar
    const data = {
        idRequest: idRequest, // ¡Aquí estaba el error! Cambiado de 'idRequeste' a 'idRequest'
        idJob: idJob,
        idCompany: idCompany,
        idStudent: idStudent
    };

    console.log(JSON.stringify(data, null, 2));

    // Enviar al servidor
    fetch('../gestion-solicitud-empresa/acepetar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        // Primero ver el texto crudo para depuración
        return response.text().then(text => {
            console.log('Respuesta cruda:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Error parseando JSON:', e);
                throw new Error('Respuesta no es JSON válido');
            }
        });
    })
    .then(data => {
        // Procesar data como JSON
        console.log('Respuesta JSON:', data);
        if (data.success) {
            alert('¡Operación completada exitosamente!');
            // Opcional: recargar la página o actualizar la UI
            location.reload(); 
        } else {
            alert('Error en la operación: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error completo en la solicitud fetch:', error);
        alert('Hubo un error al procesar la solicitud. Por favor, inténtalo de nuevo.');
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
    // Redirige a likert.php pasando los IDs como parámetros en la URL
    // Codificamos los parámetros para evitar problemas con caracteres especiales
    const params = new URLSearchParams();
    params.append('idRequest', idRequest);
    params.append('idJob', idJob);
    params.append('idCompany', idCompany);
    params.append('idStudent', idStudent);

    location.href = `../likert.php?${params.toString()}`;

    // Los fetch y SweetAlerts comentados aquí no se ejecutarán porque la página se redirige.
    // fetch("") // Este fetch no tiene sentido aquí
    // ...
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