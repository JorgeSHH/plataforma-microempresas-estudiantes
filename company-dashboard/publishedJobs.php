<?php
require_once '../database/conexion.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    echo "Debes iniciar sesión para ver tus trabajos publicados.";
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "No se pudo obtener el ID del usuario desde la sesión.";
    exit;
}

$userId = $_SESSION['user_id'];

// Consultar los trabajos publicados por el usuario
$query = "SELECT * FROM jobs WHERE id_company = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajos Publicados</title>
    <link rel="stylesheet" href="./styleCDashboard.css">
</head>
<body>
<div class="container-menu">
    <!-- Menú lateral -->
    <nav class="sidebar" id="sidebar">
        <div class="menu-toggle" id="menuToggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
            </svg>
        </div>
        <div class="logo">
            <img src="../assets/logo.png" alt="Logo">
        </div>
        <ul class="menu-items">
            <li class="menu-item">
            <a href="companyDashboard.php" class="menu-link" ondblclick="window.location.href='./companyDashboard.php';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                    <span class="menu-text">Volver</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="./publishedJobs.php" class="menu-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                        <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                    </svg>
                    <span class="menu-text">Trabajos Publicados</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content" id="mainContent">
        <h4>Trabajos Publicados</h4>
        <div id="contentSection">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="job-card" data-id="<?php echo $row['id_job']; ?>">
                        <div class="job-header">
                            <h1 class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></h1>
                            <p class="job-company">Empresa</p>
                            <div class="job-meta">
                                <span class="job-meta-item"><i>📅</i> Publicado: <?php echo htmlspecialchars($row['published_job_date']); ?></span>
                                <span class="job-meta-item"><i>⏳</i> Duración: <?php echo htmlspecialchars($row['duration_job']); ?></span>
                                <span class="job-meta-item"><i>📍</i> Tpo de trabajo: <?php echo htmlspecialchars($row['type_job']); ?></span>
                                <span class="job-meta-item"><i>💲</i> <span class="job-salary"><?php echo htmlspecialchars($row['salary']); ?></span></span>
                            </div>
                        </div>
<div class="job-category">
                            <span class="category-label">Categoría:</span>
                            <?php
                            $categoryNames = [
                                1 => 'Tecnología e innovación',
                                2 => 'Marketing y publicidad',
                                3 => 'Recursos humanos',
                                4 => 'Educación y formación',
                                5 => 'Salud y bienestar',
                                6 => 'Logística y transporte'
                            ];
                            $categoryName = isset($categoryNames[$row['id_job_category']]) ? $categoryNames[$row['id_job_category']] : 'Categoría desconocida';
                            ?>
                            <span class="category-value"><?php echo htmlspecialchars($categoryName); ?></span>
                        </div>
                        <div class="job-section">
                            <h3 class="job-section-title">Descripción</h3>
                            <p class="job-section-content"><?php echo htmlspecialchars($row['job_summary']); ?></p>
                        </div>
                        <div class="job-section">
                            <h3 class="job-section-title">Requisitos</h3>
                            <p class="job-section-content"><?php echo htmlspecialchars($row['job_requirements']); ?></p>
                        </div>
                        <div class="job-section">
                            <h3 class="job-section-title">Ubicación</h3>
                            <p class="job-section-content"><?php echo htmlspecialchars($row['job_address']); ?></p>
                        </div>
                        <div class="job-footer">
                            <button class="edit-button apply-button" data-id="<?php echo $row['id_job']; ?>">Editar</button>
                            <button class="delete-button apply-button" data-id="<?php echo $row['id_job']; ?>">Eliminar</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No tienes trabajos publicados.</p>
            <?php endif; ?>
        </div>
    </main>
<!-- Columna Derecha -->
<div class="sidebar-right">
    <!-- Barra de búsqueda -->
    

   

    <!-- Sección de Contratos con scroll -->
    <div class="contracts-section">
        
        <div class="filter-buttons-container" style="max-height: 240px; overflow-y: auto;">
        <h3>Contratos</h3>
        <div class="contracts-container">
            <!-- Elemento repetido de contrato -->
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre del Estudiante</div>
                    <div class="job-title">Título del trabajo</div>
                </div>
                <button class="view-button">Ver</button>
            </div>
            
            <!-- Repetir elementos para demostrar el scroll -->
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre del Estudiante</div>
                    <div class="job-title">Título del tranajo</div>
                </div>
                <button class="view-button">Verr</button>
            </div>
     
            
            </div>
        </div>
         <!-- Más elementos... (repetir estructura según necesidad) -->
    </div>
</div>
    <!-- Ventana modal para editar trabajos -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModalButton">&times;</span>
            <h2>Editar Trabajo</h2>
            <form id="editJobForm">
                <input type="hidden" id="job-id" name="job-id">
                <label for="job-title">Título del empleo:</label>
                <input type="text" id="job-title" name="job-title" required>
                
                <label for="job-category">Categoría:</label>
                <select id="job-category" name="job-category" required>
                    <option value="1">Tecnología e innovación</option>
                    <option value="2">Marketing y publicidad</option>
                    <option value="3">Recursos humanos</option>
                    <option value="4">Educación y formación</option>
                    <option value="5">Salud y bienestar</option>
                    <option value="6">Logística y transporte</option>
                </select>
                
                <label for="job-type">Tipo de trabajo:</label>
                <select id="job-type" name="job-type" required>
                    <option value="presencial">Presencial</option>
                    <option value="remoto">Remoto</option>
                </select>
                
                <label for="job-salary">Salario:</label>
                <input type="text" id="job-salary" name="job-salary" required>
                
                <label for="job-duration">Duración:</label>
                <input type="text" id="job-duration" name="job-duration" required>
                
                <label for="job-location">Ubicación:</label>
                <input type="text" id="job-location" name="job-location" required>
                
                <label for="job-requirements">Requisitos:</label>
                <textarea id="job-requirements" name="job-requirements" required></textarea>
                
                <label for="job-description">Descripción:</label>
                <textarea id="job-description" name="job-description" required></textarea>
                
                <button type="submit" class="submit-button">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>
<script src="./scriptPublishedJobs.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const closeModalButton = document.getElementById('closeModalButton');
    const editJobForm = document.getElementById('editJobForm');
    const jobCards = document.querySelectorAll('.job-card');
    const jobIdInput = document.getElementById('job-id');

    // Abrir la ventana modal para editar
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const jobId = button.getAttribute('data-id');
            const jobCard = document.querySelector(`.job-card[data-id="${jobId}"]`);
            
            // Cargar datos en el formulario
            jobIdInput.value = jobId;
            document.getElementById('job-title').value = jobCard.querySelector('.job-title').textContent;
            document.getElementById('job-salary').value = jobCard.querySelector('.job-salary').textContent;
            document.getElementById('job-duration').value = jobCard.querySelector('.job-meta-item:nth-child(2)').textContent.split(': ')[1];
            document.getElementById('job-location').value = jobCard.querySelector('.job-meta-item:nth-child(3)').textContent.split(': ')[1];
            document.getElementById('job-requirements').value = jobCard.querySelector('.job-section-content').textContent;
            document.getElementById('job-description').value = jobCard.querySelector('.job-section-content').textContent;

            modal.style.display = 'block';
        });
    });

    // Cerrar la ventana modal al hacer clic en el botón de cierre
    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Cerrar la ventana modal al hacer clic fuera del contenido
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Guardar cambios
    editJobForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(editJobForm);

        fetch('./updateJob.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === '1') {
                alert('Trabajo actualizado correctamente.');
                location.reload();
            } else {
                alert('Error al actualizar el trabajo.');
            }
        });
    });

    // Eliminar trabajo
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', () => {
            const jobId = button.getAttribute('data-id');

            if (confirm('¿Estás seguro de que deseas eliminar este trabajo?')) {
                fetch('./deleteJob.php', {
                    method: 'POST',
                    body: JSON.stringify({ id_job: jobId }),
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.text())
                .then(data => {
                    if (data === '1') {
                        alert('Trabajo eliminado correctamente.');
                        location.reload();
                    } else {
                        alert('Error al eliminar el trabajo.');
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>