
// Selecciona todos los botones con data-action="aceptar"
const aceptarButtons = document.querySelectorAll('[data-action="aceptar"]');

// Selecciona todos los botones con data-action="rechazar"
const rechazarButtons = document.querySelectorAll('[data-action="rechazar"]');

// Selecciona el botón con data-action="verPerfil" (usamos querySelector porque asumimos que solo hay uno)
const verPerfilButton = document.querySelector('[data-action="verPerfil"]');

// Selecciona todos los botones con data-action="calificar"
const calificarButtons = document.querySelectorAll('[data-action="calificar"]');

// Función genérica para añadir el event listener y manejar la acción
function addActionListener(elements) {
    // querySelectorAll devuelve un NodeList, que puede iterarse con forEach directamente.
    elements.forEach(button => {
        button.addEventListener('click', (event) => {
            const action = event.currentTarget.dataset.action; // Obtenemos el valor del data attribute

            switch (action) {
                case 'verPerfil':
                    fetch('../gestion-solicitud-empresa/verPerfil.php')
                    .then(response => response.json())
                        then(data => {
                                // Check for an 'error' property in the received data
                                if (data.error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: data.error,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    return; // Stop execution if there's an error
                                }

                                // Helper function to safely get text from data, including nested objects
                                // It now accepts an optional 'parentObject' for nested properties
                                const getText = (field, parentObject = data) => {
                                    if (parentObject && typeof parentObject === 'object' && parentObject[field] !== undefined) {
                                        return parentObject[field];
                                    }
                                    return ''; // Return an empty string if the field is not found or parentObject is null/undefined
                                };

                                // Construct the modal content HTML
                                const modalContent = () => { // No longer needs 'data' as a parameter, as it's in scope
                                    const profileImageHtml = data.img_profile ?
                                        `<img src="data:image/jpeg;base64,${data.img_profile}" alt="Logo del estudiante" id="company-logo-img">` :
                                        `<img src="../assets/default-logo.png" alt="Logo por defecto" id="company-logo-img">`;

                                    // --- Courses Taken ---
                                    let coursesHtml = '<p>No se han registrado cursos.</p>';
                                    if (data.courses_taken && data.courses_taken.length > 0) {
                                        coursesHtml = '<ul>';
                                        data.courses_taken.forEach(course => {
                                            // Accessing properties directly from the 'course' object
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

                                    // --- Skills ---
                                    let skillsHtml = '<p>No se han registrado habilidades.</p>';
                                    if (data.student_skills) {
                                        // Your PHP code's example output for student_skills showed multi-line text.
                                        // If it's comma-separated, split by comma. If it's multi-line, split by newline.
                                        // Let's assume it's multi-line for this example based on your provided array.
                                        const skills = data.student_skills.split('\n').map(skill => skill.trim()).filter(skill => skill !== '');
                                        if (skills.length > 0) {
                                            skillsHtml = '<ul>';
                                            skills.forEach(skill => {
                                                skillsHtml += `<li>${skill}</li>`;
                                            });
                                            skillsHtml += '</ul>';
                                        }
                                    }

                                    // --- Job History ---
                                    let jobHistoryHtml = '<p>No se ha registrado historial de trabajos.</p>';
                                    if (data.job_history && data.job_history.length > 0) {
                                        jobHistoryHtml = '<ul>';
                                        data.job_history.forEach(job => {
                                            // Accessing properties directly from the 'job' object
                                            jobHistoryHtml += `
                                                <li>
                                                    <ul>
                                                        <li><strong>Empresa:</strong> ${getText('company_name', job)}</li>
                                                        <li><strong>Posición:</strong> ${getText('position', job)}</li>
                                                        <li><strong>Inicio:</strong> ${getText('start_date', job)}</li>
                                                        <li><strong>Fin:</strong> ${getText('end_date', job)}</li>
                                                        <li><strong>Descripción:</strong> ${getText('description', job)}</li>
                                                    </ul>
                                                </li>`;
                                        });
                                        jobHistoryHtml += '</ul>';
                                    }

                                    const dateOfBirthFormatted = data.date_of_birth ? new Date(data.date_of_birth).toISOString().split('T')[0] : '';

                                    // --- Address Data ---
                                    // Access address properties via data.address.propertyName
                                    const addressStreet = getText('street', data.address);
                                    const addressSector = getText('sector', data.address);
                                    const addressParish = getText('parish', data.address);
                                    const addressState = getText('state', data.address);

                                    // Your main HTML structure
                                    return `
                                        <main class="main-content" id="mainContent" style="z-index: 1; position: relative; overflow: hidden; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); background-color: #fff; border-radius: 8px; padding: 20px; margin: 20px auto; max-width: 1200px;">
                                            <div class="cv-container">
                                                <header class="cv-header" style="border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px;">
                                                    <div class="header-content" style="display: flex; align-items: center;">
                                                        <div class="profile-pic" style="flex-shrink: 0; margin-right: 20px;">
                                                            ${profileImageHtml}
                                                        </div>
                                                        <div class="header-text" style="flex-grow: 1;">
                                                            <h1 class="company-name" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">${getText('studen_name')} ${getText('student_lastname')}</h1>
                                                            <div class="contact-info" style="font-size: 14px; color: #555;">
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
                                                <div class="edit-profile-button-container" style="text-align: center; margin-top: 20px;">
                                                    <a href="editStudentProfile.php" class="edit-profile-button" style="display: inline-block; padding: 10px 20px; background-color: #3085d6; color: #fff; text-decoration: none; border-radius: 5px;">Editar Perfil</a>
                                                </div>
                                            </div>
                                        </main>`;
                                };

                                Swal.fire({
                                    title: 'Detalles del Estudiante',
                                    html: modalContent(), // Call the function without 'data' parameter
                                    confirmButtonText: 'Entendido',
                                    showCloseButton: true,
                                    width: '1000px',
                                    scrollbar: true
                                });
                            }) .catch(error => {
                                console.error('Error fetching profile:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No se pudo cargar el perfil.',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar'
                                });
                                    
                    })
        
                    break;
                case 'aceptar':
                    Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¡Acepta el contrato!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, aceptar'
                            })
                    break;
                case 'rechazar':
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡Rechaza el contrato!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, rechazar'
                        })
                    break;
                case 'calificar':
                    console.log('Se hizo clic en Calificar');
                    // Lógica específica para calificar
                    break;
                default:
                    console.log(`Acción no reconocida: ${action}`);
            }
        });
    });
}

// Aplicar la función a cada una de tus colecciones de elementos
addActionListener(aceptarButtons);
addActionListener(rechazarButtons);
addActionListener(calificarButtons);

// Para el botón de "Ver Perfil", ya que lo seleccionamos individualmente con querySelector,
// lo manejamos un poco diferente si solo es un elemento.
if (verPerfilButton) {
    verPerfilButton.addEventListener('click', (event) => {
        const action = event.currentTarget.dataset.action;
        if (action === 'verPerfil') {
            console.log('Se hizo clic en Ver Perfil');
            // Lógica específica para ver el perfil
        }
    });
}

// aceptar.addEventListener("click", function() {
//     Swal.fire({
//         title: '¿Estás seguro?',
//         text: "¡Acepta el contrato!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Sí, aceptar'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire(
//                 '¡Aceptado!',
//                 'El contrato ha sido aceptado.',
//                 'success'
//             );
//         }
//     });
// });
// rechazar.addEventListener("click", function() {
//     Swal.fire({
//         title: '¿Estás seguro?',
//         text: "¡Rechaza el contrato!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Sí, rechazar'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire(
//                 '¡Rechazado!',
//                 'El contrato ha sido rechazado.',
//                 'error'
//             );
//         }
//     });
// });

// verPerfil.addEventListener("click", function() {
//     fetch('../gestion-solicitud-empresa/verPerfil.php')
//         .then(response => response.json())
//         .then(data => {
//     // Check for an 'error' property in the received data
//     if (data.error) {
//         Swal.fire({
//             title: 'Error',
//             text: data.error,
//             icon: 'error',
//             confirmButtonText: 'OK'
//         });
//         return; // Stop execution if there's an error
//     }

//     // Helper function to safely get text from data, including nested objects
//     // It now accepts an optional 'parentObject' for nested properties
//     const getText = (field, parentObject = data) => {
//         if (parentObject && typeof parentObject === 'object' && parentObject[field] !== undefined) {
//             return parentObject[field];
//         }
//         return ''; // Return an empty string if the field is not found or parentObject is null/undefined
//     };

//     // Construct the modal content HTML
//     const modalContent = () => { // No longer needs 'data' as a parameter, as it's in scope
//         const profileImageHtml = data.img_profile ?
//             `<img src="data:image/jpeg;base64,${data.img_profile}" alt="Logo del estudiante" id="company-logo-img">` :
//             `<img src="../assets/default-logo.png" alt="Logo por defecto" id="company-logo-img">`;

//         // --- Courses Taken ---
//         let coursesHtml = '<p>No se han registrado cursos.</p>';
//         if (data.courses_taken && data.courses_taken.length > 0) {
//             coursesHtml = '<ul>';
//             data.courses_taken.forEach(course => {
//                 // Accessing properties directly from the 'course' object
//                 coursesHtml += `
//                     <li>
//                         <ul>
//                             <li><strong>Nombre del Curso:</strong> ${getText('course_name', course)}</li>
//                             <li><strong>Institución:</strong> ${getText('institution', course)}</li>
//                             <li><strong>Duración:</strong> ${getText('duration', course)}</li>
//                             <li><strong>Fecha de Finalización:</strong> ${getText('completion_date', course)}</li>
//                         </ul>
//                     </li>`;
//             });
//             coursesHtml += '</ul>';
//         }

//         // --- Skills ---
//         let skillsHtml = '<p>No se han registrado habilidades.</p>';
//         if (data.student_skills) {
//             // Your PHP code's example output for student_skills showed multi-line text.
//             // If it's comma-separated, split by comma. If it's multi-line, split by newline.
//             // Let's assume it's multi-line for this example based on your provided array.
//             const skills = data.student_skills.split('\n').map(skill => skill.trim()).filter(skill => skill !== '');
//             if (skills.length > 0) {
//                 skillsHtml = '<ul>';
//                 skills.forEach(skill => {
//                     skillsHtml += `<li>${skill}</li>`;
//                 });
//                 skillsHtml += '</ul>';
//             }
//         }

//         // --- Job History ---
//         let jobHistoryHtml = '<p>No se ha registrado historial de trabajos.</p>';
//         if (data.job_history && data.job_history.length > 0) {
//             jobHistoryHtml = '<ul>';
//             data.job_history.forEach(job => {
//                 // Accessing properties directly from the 'job' object
//                 jobHistoryHtml += `
//                     <li>
//                         <ul>
//                             <li><strong>Empresa:</strong> ${getText('company_name', job)}</li>
//                             <li><strong>Posición:</strong> ${getText('position', job)}</li>
//                             <li><strong>Inicio:</strong> ${getText('start_date', job)}</li>
//                             <li><strong>Fin:</strong> ${getText('end_date', job)}</li>
//                             <li><strong>Descripción:</strong> ${getText('description', job)}</li>
//                         </ul>
//                     </li>`;
//             });
//             jobHistoryHtml += '</ul>';
//         }

//         const dateOfBirthFormatted = data.date_of_birth ? new Date(data.date_of_birth).toISOString().split('T')[0] : '';

//         // --- Address Data ---
//         // Access address properties via data.address.propertyName
//         const addressStreet = getText('street', data.address);
//         const addressSector = getText('sector', data.address);
//         const addressParish = getText('parish', data.address);
//         const addressState = getText('state', data.address);

//         // Your main HTML structure
//         return `
//             <main class="main-content" id="mainContent" style="z-index: 1; position: relative; overflow: hidden; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); background-color: #fff; border-radius: 8px; padding: 20px; margin: 20px auto; max-width: 1200px;">
//                 <div class="cv-container">
//                     <header class="cv-header" style="border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px;">
//                         <div class="header-content" style="display: flex; align-items: center;">
//                             <div class="profile-pic" style="flex-shrink: 0; margin-right: 20px;">
//                                 ${profileImageHtml}
//                             </div>
//                             <div class="header-text" style="flex-grow: 1;">
//                                 <h1 class="company-name" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">${getText('studen_name')} ${getText('student_lastname')}</h1>
//                                 <div class="contact-info" style="font-size: 14px; color: #555;">
//                                     <p><strong>Correo:</strong> ${getText('student_email')}</p>
//                                     <p><strong>Teléfono:</strong> ${getText('student_phone')}</p>
//                                     <p><strong>Cédula:</strong> ${getText('student_identy_card')}</p>
//                                     <p><strong>Sexo:</strong> ${getText('student_sex')}</p>
//                                     <p><strong>Fecha de Nacimiento:</strong> ${dateOfBirthFormatted}</p>
//                                     <p><strong>Preferencias de Empleo:</strong> ${getText('job_preferences')}</p>
//                                 </div>
//                             </div>
//                         </div>
//                     </header>
//                     <div class="cv-content" style="display: flex; gap: 20px;">
//                         <div class="left-column" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
//                             <section class="cv-section about" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Sobre mí</h3>
//                                 <p>${getText('student_skills')}</p>
//                             </section>
//                             <section class="cv-section" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Dirección</h3>
//                                 <ul style="list-style: none; padding: 0;">
//                                     <li><b>Calle:</b> ${addressStreet}</li>
//                                     <li><b>Sector:</b> ${addressSector}</li>
//                                     <li><b>Parroquia:</b> ${addressParish}</li>
//                                     <li><b>Estado:</b> ${addressState}</li>
//                                 </ul>
//                             </section>
//                             <section class="cv-section education" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Cursos Realizados</h3>
//                                 ${coursesHtml}
//                             </section>
//                         </div>
//                         <div class="right-column" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
//                             <section class="cv-section experience" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Mis Habilidades</h3>
//                                 ${skillsHtml}
//                             </section>
//                             <section class="cv-section projects" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Documentos Profesionales</h3>
//                                 <ul style="list-style: none; padding: 0;">
//                                     <li><a href="${getText('portfolio')}" target="_blank">Portafolio</a></li>
//                                     <li><a href="${getText('curriculum_vitae')}" target="_blank">Curriculum Vitae</a></li>
//                                 </ul>
//                             </section>
//                             <section class="cv-section education" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Nivel de Educación</h3>
//                                 <p>${getText('education_level')}</p>
//                             </section>
//                             <section class="cv-section education" style="margin-bottom: 20px;">
//                                 <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Historial de Trabajos</h3>
//                                 ${jobHistoryHtml}
//                             </section>
//                         </div>
//                     </div>
//                     <div class="edit-profile-button-container" style="text-align: center; margin-top: 20px;">
//                         <a href="editStudentProfile.php" class="edit-profile-button" style="display: inline-block; padding: 10px 20px; background-color: #3085d6; color: #fff; text-decoration: none; border-radius: 5px;">Editar Perfil</a>
//                     </div>
//                 </div>
//             </main>`;
//     };

//     Swal.fire({
//         title: 'Detalles del Estudiante',
//         html: modalContent(), // Call the function without 'data' parameter
//         confirmButtonText: 'Entendido',
//         showCloseButton: true,
//         width: '1000px',
//         scrollbar: true
//     });
// }) .catch(error => {
//     console.error('Error fetching profile:', error);
//     Swal.fire({
//         title: 'Error',
//         text: 'No se pudo cargar el perfil.',
//         icon: 'error',
//         confirmButtonText: 'Cerrar'
//     });
           
//         })
        
// });

// calificar.addEventListener("click", function() {
//     location.href = "../likert.php";
// });

