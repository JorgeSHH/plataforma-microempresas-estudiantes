<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación del Desempeño del Estudiante</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Tu CSS existente */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-image: linear-gradient(0deg, rgba(11, 18, 17, 0.762), rgba(38, 96, 178, 0.432)), url('./assets/loginBg.jpg'); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; background-size: cover; background-position: center; }
        .container { background-color: rgba(255, 255, 255, 0.751); border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); width: 100%; max-width: 800px; padding: 30px; margin: 20px 0; }
        .container:hover { box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); transform: translateY(-5px); transition: all 0.3s ease; background-color: rgba(255, 255, 255, 0.95); }
        header { text-align: center; margin-bottom: 30px; }
        header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        header p { color: #7f8c8d; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }
        .survey-form { display: flex; flex-direction: column; gap: 25px; }
        .question { background-color: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .question:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); }
        .question-text { font-size: 1.2rem; color: #2c3e50; margin-bottom: 20px; font-weight: 600; }
        .likert-scale { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        .option { flex: 1; min-width: 80px; text-align: center; }
        .option input { display: none; }
        .option label { display: block; padding: 12px 5px; background-color: #ecf0f1; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; font-weight: 500; color: #34495e; }
        .option label:hover { background-color: #d6dbdf; }
        .option input:checked + label { background-color: #3498db; color: white; font-weight: 600; transform: scale(1.05); }
        .labels { display: flex; justify-content: space-between; margin-top: 8px; color: #7f8c8d; font-size: 0.9rem; }
        .submit-btn { background: linear-gradient(to right, #3498db, #2c3e50); color: white; border: none; padding: 15px 30px; font-size: 1.2rem; border-radius: 50px; cursor: pointer; transition: all 0.3s ease; margin-top: 20px; font-weight: 600; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4); }
        .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(52, 152, 219, 0.6); }
        .submit-btn:active { transform: translateY(0); }
        .footer-note { text-align: center; margin-top: 25px; color: #7f8c8d; font-size: 0.9rem; }
        .emoji-scale { display: flex; justify-content: space-between; margin-top: 10px; font-size: 1.8rem; }
        @media (max-width: 600px) { .likert-scale { flex-direction: column; } .option { width: 100%; } .container { padding: 20px 15px; } header h1 { font-size: 2rem; } }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Evaluación del Desempeño del Estudiante</h1>
            <p>Por favor, califique el desempeño del estudiante en las siguientes áreas. Su opinión es muy importante para nosotros.</p>
        </header>

        <form id="surveyForm" class="survey-form">
            <div class="question">
                <div class="question-text">1. ¿Cómo calificaría la calidad del trabajo realizado por el estudiante?</div>
                <div class="likert-scale">
                    <div class="option">
                        <input type="radio" id="q1_1" name="q1" value="1" required>
                        <label for="q1_1">1</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q1_2" name="q1" value="2">
                        <label for="q1_2">2</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q1_3" name="q1" value="3">
                        <label for="q1_3">3</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q1_4" name="q1" value="4">
                        <label for="q1_4">4</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q1_5" name="q1" value="5">
                        <label for="q1_5">5</label>
                    </div>
                </div>
                <div class="labels">
                    <span>Muy Malo</span>
                    <span>Excelente</span>
                </div>
            </div>

            <div class="question">
                <div class="question-text">2. ¿El Estudiante cumplió con el trabajo de manera satisfactoria?</div>
                <div class="likert-scale">
                    <div class="option">
                        <input type="radio" id="q2_1" name="q2" value="1" required>
                        <label for="q2_1">1</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q2_2" name="q2" value="2">
                        <label for="q2_2">2</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q2_3" name="q2" value="3">
                        <label for="q2_3">3</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q2_4" name="q2" value="4">
                        <label for="q2_4">4</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q2_5" name="q2" value="5">
                        <label for="q2_5">5</label>
                    </div>
                </div>
                <div class="labels">
                    <span>Muy Impuntual</span>
                    <span>Muy Puntual</span>
                </div>
            </div>

            <div class="question">
                <div class="question-text">3. ¿El estudiante cumplió con las pautas acordadas durante el trabajo?</div>
                <div class="likert-scale">
                    <div class="option">
                        <input type="radio" id="q3_1" name="q3" value="1" required>
                        <label for="q3_1">1</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q3_2" name="q3" value="2">
                        <label for="q3_2">2</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q3_3" name="q3" value="3">
                        <label for="q3_3">3</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q3_4" name="q3" value="4">
                        <label for="q3_4">4</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q3_5" name="q3" value="5">
                        <label for="q3_5">5</label>
                    </div>
                </div>
                <div class="labels">
                    <span>Muy Negativa</span>
                    <span>Muy Positiva</span>
                </div>
            </div>

            <div class="question">
                <div class="question-text">4. ¿Qué tan satisfecho está con la comunicación del estudiante?</div>
                <div class="likert-scale">
                    <div class="option">
                        <input type="radio" id="q4_1" name="q4" value="1" required>
                        <label for="q4_1">1</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q4_2" name="q4" value="2">
                        <label for="q4_2">2</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q4_3" name="q4" value="3">
                        <label for="q4_3">3</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q4_4" name="q4" value="4">
                        <label for="q4_4">4</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q4_5" name="q4" value="5">
                        <label for="q4_5">5</label>
                    </div>
                </div>
                <div class="labels">
                    <span>Poco Satisfecho</span>
                    <span>Muy Satisfecho</span>
                </div>
            </div>

            <div class="question">
                <div class="question-text">5. En general, ¿cómo calificaría el desempeño del estudiante?</div>
                <div class="likert-scale">
                    <div class="option">
                        <input type="radio" id="q5_1" name="q5" value="1" required>
                        <label for="q5_1">1</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q5_2" name="q5" value="2">
                        <label for="q5_2">2</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q5_3" name="q5" value="3">
                        <label for="q5_3">3</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q5_4" name="q5" value="4">
                        <label for="q5_4">4</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="q5_5" name="q5" value="5">
                        <label for="q5_5">5</label>
                    </div>
                </div>
                <div class="labels">
                    <span>Muy Insatisfecho</span>
                    <span>Muy Satisfecho</span>
                </div>
            </div>

            <button type="submit" class="submit-btn">Enviar Evaluación</button>
        </form>

        <div class="footer-note">
            <p>Su respuesta les ayuda a mejorar.</p>
        </div>
    </div>

    <script>
        // Obtener los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const idRequest = urlParams.get('idRequest');
        const idJob = urlParams.get('idJob');
        const idCompany = urlParams.get('idCompany');
        const idStudent = urlParams.get('idStudent');

        document.getElementById('surveyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Obtener respuestas
            const q1 = parseInt(document.querySelector('input[name="q1"]:checked').value);
            const q2 = parseInt(document.querySelector('input[name="q2"]:checked').value);
            const q3 = parseInt(document.querySelector('input[name="q3"]:checked').value);
            const q4 = parseInt(document.querySelector('input[name="q4"]:checked').value);
            const q5 = parseInt(document.querySelector('input[name="q5"]:checked').value);

            // Calcular promedio
            const promedio = (q1 + q2 + q3 + q4 + q5) / 5;

            // Determinar nivel de satisfacción (tu lógica existente)
            let nivel = "";
            let color = "";
            let emoji = "";

            if (promedio >= 4.5) {
                nivel = "Excelente";
                color = "#2ecc71";
                emoji = "😍";
            } else if (promedio >= 3.5) {
                nivel = "Bueno";
                color = "#3498db";
                emoji = "😊";
            } else if (promedio >= 2.5) {
                nivel = "Regular";
                color = "#f39c12";
                emoji = "😐";
            } else if (promedio >= 1.5) {
                nivel = "Deficiente";
                color = "#e74c3c";
                emoji = "😞";
            } else {
                nivel = "Malo";
                color = "#c0392b";
                emoji = "😠";
            }

            // Crear texto de resultados
            const resultados = `
                <div style="text-align: left; margin: 20px 0;">
                    <p><strong>1. Calidad del trabajo:</strong> ${q1}/5</p>
                    <p><strong>2. Puntualidad:</strong> ${q2}/5</p>
                    <p><strong>3. Actitud:</strong> ${q3}/5</p>
                    <p><strong>4. Comunicación:</strong> ${q4}/5</p>
                    <p><strong>5. Desempeño general:</strong> ${q5}/5</p>
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                        <p style="font-size: 1.2rem;"><strong>Puntuación promedio:</strong> ${promedio.toFixed(1)}/5</p>
                    </div>
                </div>
            `;

            // Mostrar resultados con SweetAlert2
            Swal.fire({
                title: `Resultados de la Evaluación ${emoji}`,
                html: `<div style="font-size: 1.5rem; color: ${color}; margin: 15px 0;">${nivel}</div>
                        ${resultados}`,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#3498db',
                customClass: {
                    popup: 'sweet-popup',
                    title: 'sweet-title'
                }
            }).then((result) => {
                // Una vez que el usuario cierra el SweetAlert, enviamos los datos a calificar.php
                if (result.isConfirmed) {
                    sendDataToCalificarPHP(promedio);
                }
            });
        });

        // Función para enviar los datos a calificar.php
        function sendDataToCalificarPHP(ratingValue) {
            // Verifica que los IDs no sean nulos (si likert.php se carga directamente sin parámetros)
            if (!idRequest || !idJob || !idCompany || !idStudent) {
                console.error("Faltan parámetros necesarios para calificar. Asegúrate de que la función handleCalificar los esté pasando.");
                Swal.fire('Error', 'No se pudieron obtener los datos de la solicitud para calificar.', 'error');
                return;
            }

            const dataToSend = {
                idRequest: idRequest,
                idJob: idJob,
                idCompany: idCompany,
                idStudent: idStudent,
                rating: ratingValue.toFixed(1) // Asegura un decimal
            };
         // Para depuración, puedes eliminarlo en producción
            

            fetch('./gestion-solicitud-empresa/calificar.php', { // Ajusta la ruta si es necesario
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Indicamos que enviamos JSON
                },
                body: JSON.stringify(dataToSend) // Convertimos el objeto a JSON
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // O response.text() si calificar.php no devuelve JSON
            })
            .then(data => {
                console.log('Respuesta de calificar.php:', data);
                if (data.success) {
                    Swal.fire('¡Éxito!', data.message, 'success')
                        .then(() => {
                            // Redirigir o actualizar la UI después de calificar exitosamente
                            // Por ejemplo, volver a la página anterior o recargar
                            window.history.back(); // Vuelve a la página que llamó a likert.php
                        });
                } else {
                    Swal.fire('Error', data.message || 'Hubo un error al guardar la calificación.', 'error');
                }
            })
            .catch(error => {
                console.error('Error al enviar la calificación:', error);
                Swal.fire('Error de Conexión', 'No se pudo enviar la calificación al servidor. Inténtalo de nuevo.', 'error');
            });
        }

        // Animación para los elementos de la encuesta (tu código existente)
        document.querySelectorAll('.question').forEach((question, index) => {
            setTimeout(() => {
                question.style.opacity = '1';
                question.style.transform = 'translateY(0)';
            }, 300 * index);

            question.style.opacity = '0';
            question.style.transform = 'translateY(20px)';
            question.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });

    </script>
</body>
</html>