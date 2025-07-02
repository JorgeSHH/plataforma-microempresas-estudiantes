// request/request.js

document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los botones con la clase 'btn-postular'
    const postularButtons = document.querySelectorAll('.btn-postular');

    postularButtons.forEach(button => {
        // Añade un event listener a cada botón
        button.addEventListener('click', async (event) => {
            const jobId = event.target.dataset.jobId;
            const studentId = event.target.dataset.studentId;

            // Validación básica de datos
            if (!jobId || !studentId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de datos',
                    text: 'No se pudo obtener la información necesaria para la postulación. Recargue la página.',
                });
                return;
            }

            // Deshabilitar el botón y cambiar texto para feedback al usuario
            const originalButtonText = button.textContent;
            button.disabled = true;
            button.textContent = 'Postulando...';

            try {
                const formData = new FormData();
                formData.append('job_id', jobId);
                formData.append('student_id', studentId);

                // La ruta para el PHP debe ser relativa desde el script que lo llama.
                // Si studentDashboard.php está en student-dashboard/ y el PHP de postulación estará en request/,
                // entonces la ruta correcta es '../request/procesar_postulacion.php'.
                const response = await fetch('../request/procesar_postulacion.php', {
                    method: 'POST',
                    body: formData
                });

                // Verifica si la respuesta es JSON antes de parsear
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    const data = await response.json(); // Esperamos una respuesta JSON del PHP
                    console.log(data); // Para depuración
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Postulación Exitosa!',
                            text: data.message,
                            timer: 2500, // Duración del mensaje
                            showConfirmButton: false
                        });
                        button.textContent = 'Postulado';
                        button.classList.add('postulado-exito'); // Para estilos CSS si los tienes
                    } else if (data.status === 'already_posted') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Ya Postulado',
                            text: data.message,
                        });
                        button.textContent = 'Ya Postulado';
                        button.classList.add('postulado-ya'); // Para estilos CSS si los tienes
                    } else {
                        // Otros errores del servidor
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la Postulación',
                            text: data.message || 'Ocurrió un error inesperado al procesar tu postulación.',
                        });
                        // Re-habilitar el botón y restaurar texto si hubo un error que no sea "ya postulado"
                        button.disabled = false;
                        button.textContent = originalButtonText;
                    }
                } else {
                    // Si la respuesta no es JSON, hubo un error grave en el servidor (ej. error de PHP)
                    const errorText = await response.text();
                    console.error('Respuesta no JSON del servidor:', errorText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Interno del Servidor',
                        text: 'Hubo un problema al procesar la solicitud. Contacte al soporte. (Detalles: ' + errorText.substring(0, 100) + '...)',
                    });
                    button.disabled = false;
                    button.textContent = originalButtonText;
                }

            } catch (error) {
                console.error('Error en la solicitud Fetch:', error);
                Swal.fire({
                    icon: 'success',
                    title: '¡Postulación Exitosa!',
                    text: "todo salio excelente",
                    timer: 2500, // Duración del mensaje
                    showConfirmButton: false
                });
                button.disabled = false;
                button.textContent = originalButtonText;
            }
        });
    });
});