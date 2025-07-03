// Función para manejar la acción de Aceptar
// Función para manejar la acción de Aceptar


// Función para manejar la acción de Rechazar
function handleRechazar(idRequest, idStudent) {
    const formData = new FormData();
    formData.append('request_id', idRequest); // Usar idRequest en lugar de requestId
    
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
            // Enviar la solicitud al servidor para eliminar el contrato
            fetch('../gestion-solicitud-empresa/rechazar.php', {
                method: 'POST', // Asegúrate de que sea POST
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                } else {
                    Swal.fire(
                        '¡Rechazado!',
                        data.message,
                        'success'
                    ).then(() => {
                        // Opcional: Recargar la página o actualizar la tabla
                        location.reload();
                    });
                    
                    // Aquí puedes usar data.request_id si necesitas hacer algo con él
                    console.log("ID Request asociado:", data.request_id);
                }
            })
            .catch(error => {
                console.error('Error al eliminar el contrato:', error);
                Swal.fire('Error', 'Ocurrió un error al rechazar la solicitud', 'error');
            });
        }
    });
}





// Función para manejar la acción de Ver
function handleVer(idRequest, idJob, idCompany, idStudent) {
    // Asegúrate de que el ID de la solicitud se pase a la URL
    fetch(`../gestion-solicitud-empresa/verPerfil.php?request_id=${idRequest}`)
        .then(response => response.json())
        .then(data => {
            // Verificar si hay un error en la respuesta
            if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Detener la ejecución si hay un error
            }

            // Función auxiliar para obtener texto de los datos
            const getText = (field, parentObject = data) => {
                if (parentObject && typeof parentObject === 'object' && parentObject[field] !== undefined) {
                    return parentObject[field];
                }
                return ''; // Retornar una cadena vacía si no se encuentra el campo
            };

            // Construir el contenido del modal
            const modalContent = () => {
                const profileImageHtml = data.img_profile ?
                    `<${data.img_profile}"">` :
                    `<img src="../assets/1.png"  style="width: 150px; height: 150px; margin-left: 700px; margin-buttom: 1002px; border-radius: 50%;">`;

                // --- Cursos ---
                let coursesHtml = '<p>No se han registrado cursos.</p>';
                if (data.courses_taken && data.courses_taken.length > 0) {
                    coursesHtml = '<ul>';
                    data.courses_taken.forEach(course => {
                        coursesHtml += `
                            <li>
                                <ul>
                                    <li><strong>Nombre del Curso:</strong> ${getText('course_name', course)}</li>
                                    <li><strong>Institución:</strong> ${getText('institution', course)}</li>
                                    <li><strong>Duración:</strong> ${getText('duration', course)}</li>
                                    <li><strong>Fecha de Finalización:</strong> ${getText('completion_date', course)}</li>
                                </ul>
                            </li>`;
                    });
                    coursesHtml += '</ul>';
                }

                // --- Habilidades ---
                let skillsHtml = '<p>No se han registrado habilidades.</p>';
                if (data.student_skills) {
                    const skills = data.student_skills.split('\n').map(skill => skill.trim()).filter(skill => skill !== '');
                    if (skills.length > 0) {
                        skillsHtml = '<ul>';
                        skills.forEach(skill => {
                            skillsHtml += `<li>${skill}</li>`;
                        });
                        skillsHtml += '</ul>';
                    }
                }

                // --- Historial de Trabajo ---
                let jobHistoryHtml = '<p>No se ha registrado historial de trabajos.</p>';
                if (data.job_history && data.job_history.length > 0) {
                    jobHistoryHtml = '<ul>';
                    data.job_history.forEach(job => {
                        jobHistoryHtml += `
                            <li>
                                <ul>
                                    <li><strong>Empresa:</strong> ${getText('company', job)}</li>
                                    <li><strong>Posición:</strong> ${getText('job_position', job)}</li>
                                    <li><strong>Periodo:</strong> ${getText('period', job)}</li>
                        
                                </ul>
                            </li>`;
                    });
                    jobHistoryHtml += '</ul>';
                }

                const dateOfBirthFormatted = data.date_of_birth ? new Date(data.date_of_birth).toISOString().split('T')[0] : '';

                // --- Datos de Dirección ---
                const addressStreet = getText('street', data.address);
                const addressSector = getText('sector', data.address);
                const addressParish = getText('parish', data.address);
                const addressState = getText('state', data.address);

                // Estructura principal del HTML
                return `
                    <main class="main-content" id="mainContent" style="z-index: 1; position: relative; overflow: hidden; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); background-color: #fff; border-radius: 8px; padding: 20px; margin: 20px auto; max-width: 1200px;">
                        <div class="cv-container">
                            <header class="cv-header" style="border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px; color: white;">
                                <div class="header-content" style="display: flex; align-items: center;">
                                    <div class="profile-pic" style="flex-shrink: 0; margin-right: 20px;">
                                        ${profileImageHtml}
                                    </div>
                                    <div class="header-text" style="flex-grow: 1;">
                                        <h1 class="company-name" style="font-size: 24px; font-weight: bold; margin-bottom: 10px; color: white">${getText('studen_name')} ${getText('student_lastname')}</h1>
                                        <div class="contact-info" style="font-size: 14px; color: white;">
                                            <p><strong>Correo:</strong> ${getText('student_email')}</p>
                                            <p><strong>Teléfono:</strong> ${getText('student_phone')}</p>
                                            <p><strong>Cédula:</strong> ${getText('student_identy_card')}</p>
                                            <p><strong>Sexo:</strong> ${getText('student_sex')}</p>
                                            <p><strong>Fecha de Nacimiento:</strong> ${dateOfBirthFormatted}</p>
                                            <p><strong>Preferencias de Empleo:</strong> ${getText('job_preferences')}</p>
                                        </div>
                                    </div>
                                </div>
                            </header>
                            <div class="cv-content" style="display: flex; gap: 20px;">
                                <div class="left-column" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
                                    <section class="cv-section about" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Sobre mí</h3>
                                        <p>${getText('student_skills')}</p>
                                    </section>
                                    <section class="cv-section" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Dirección</h3>
                                        <ul style="list-style: none; padding: 0;">
                                            <li><b>Calle:</b> ${addressStreet}</li>
                                            <li><b>Sector:</b> ${addressSector}</li>
                                            <li><b>Parroquia:</b> ${addressParish}</li>
                                            <li><b>Estado:</b> ${addressState}</li>
                                        </ul>
                                    </section>
                                    <section class="cv-section education" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Cursos Realizados</h3>
                                        ${coursesHtml}
                                    </section>
                                </div>
                                <div class="right-column" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
                                    <section class="cv-section experience" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Mis Habilidades</h3>
                                        ${skillsHtml}
                                    </section>
                                    <section class="cv-section projects" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Documentos Profesionales</h3>
                                        <ul style="list-style: none; padding: 0;">
                                            <li><a href="${getText('portfolio')}" target="_blank">Portafolio</a></li>
                                            <li><a href="${getText('curriculum_vitae')}" target="_blank">Curriculum Vitae</a></li>
                                        </ul>
                                    </section>
                                    <section class="cv-section education" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Nivel de Educación</h3>
                                        <p>${getText('education_level')}</p>
                                    </section>
                                    <section class="cv-section education" style="margin-bottom: 20px;">
                                        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Historial de Trabajos</h3>
                                        ${jobHistoryHtml}
                                    </section>
                                </div>
                      
                         
                        </div>
                    </main>`;
            };

            Swal.fire({
                title: 'Detalles del Estudiante',
                html: modalContent(),
                confirmButtonText: 'Entendido',
                showCloseButton: true,
                width: '1000px',
                scrollbar: true
            });
        })
        .catch(error => {
            console.error('Error fetching profile:', error);
            Swal.fire({
                title: 'Error',
                text: 'No se pudo cargar el perfil.',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        });
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