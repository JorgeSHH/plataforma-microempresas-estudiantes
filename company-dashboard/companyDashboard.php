<?php
require_once '../database/conexion.php';

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Si no ha iniciado sesión, redirigir al login
    header('Location: login.php');
    exit();
}

// Opcional: Verificar el rol si la página es específica para un rol

if ($_SESSION['user_rol'] !== 'empresa') {
    // Redirigir a una página de acceso denegado o al dashboard principal
    header('Location: ../index.php'); // O dashboard_empresa.php si es empresa
    exit();
}

// Consultar las ofertas de trabajo desde la base de datos
$query = "SELECT * FROM jobs";
$result = $conexion->query($query);

// Obtener datos de la tabla jobs
$queryJobs = "SELECT * FROM jobs WHERE id_company = ?";
$stmtJobs = $conexion->prepare($queryJobs);
$stmtJobs->bind_param("i", $userId);
$stmtJobs->execute();
$resultJobs = $stmtJobs->get_result();

// Obtener datos de la tabla companies
$userId = $_SESSION['user_id']; // Asegúrate de que 'user_id' esté configurado en la sesión al iniciar sesión
$queryCompany = "SELECT * FROM companies WHERE id_company = ?";
$stmtCompany = $conexion->prepare($queryCompany);
$stmtCompany->bind_param("i", $userId);
$stmtCompany->execute();
$resultCompany = $stmtCompany->get_result();
$company = $resultCompany->fetch_assoc();

// Obtener datos de la tabla requests
$queryRequests = "SELECT
            r.id_requests,
            r.id_job,
            r.id_company,
            r.id_student,
            j.job_title,    -- Corregido de job_title a title_job
            c.company_name, -- Corregido de company_name a name_company
            s.studen_name  -- Corregido de studen_name a name_student
        FROM
            requests AS r
        INNER JOIN
            jobs AS j ON r.id_job = j.id_job
        INNER JOIN
            companies AS c ON r.id_company = c.id_company
        INNER JOIN
            student AS s ON r.id_student = s.id_student
        WHERE
            r.id_company = ?"; // Filtrar por id_company
$stmtRequests = $conexion->prepare($queryRequests);
$stmtRequests->bind_param("i", $userId);
$stmtRequests->execute();
$resultRequests = $stmtRequests->get_result();
// Verificar si la consulta fue exitosa
if (!$resultRequests) {
    die("Error en la consulta SQL: " . $conexion->error);
}



?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Desplegable</title>
    <link rel="stylesheet" href="./styleCDashboard.css">
</head>
<body>
<div class="container-menu">
              <!-- Menú lateral -->
              <nav class="sidebar colorH" id="sidebar">
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
                    <a href="../index.php" class="menu-link" ondblclick="window.location.href='../index.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                        </svg>    
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>
                <li class="menu-item">
                <a href="'./publishedJobs.php';" class="menu-link" ondblclick="window.location.href='./publishedJobs.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                            <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                        </svg>
                        <span class="menu-text">Trabajos Publicados</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div class="menu-link" ondblclick="window.location.href='../company-profile/companyProfile.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span class="menu-text">Perfil</span>
                    </div>
                </li>
                <li class="menu-item">
                <a href="../database/logout.php" class="menu-link" ondblclick="window.location.href='../database/logout.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
            
        </nav>
        
        <!-- Contenido principal -->
        <main class="main-content" id="mainContent">
            <div class="profile-header">
            <div class="profile-info">
            <?php
            if (!empty($company['img_perfil'])) {
                $imgData = base64_encode($company['img_perfil']);
                echo '<img src="data:image/jpeg;base64,' . $imgData . '" alt="Foto de perfil" class="profile-pic">';
            } else {
                echo '<img src="../assets/default-logo.png" alt="Foto de perfil por defecto" class="profile-pic">';
            }
            ?>
            <div class="user-details">
            <!-- aca metemos el nombre del usuario -->
                <div class="user-name"><?php echo htmlspecialchars($company['company_name']); ?></div> 
                     <!-- aca metemos el Apellido del usuario -->
                <div class="user-handle"><?php echo htmlspecialchars($company['company_email']); ?></div>
            </div>
            </div>
            </div>
            <section class="welcome">
                <h1>Bienvenido, Haz crecer tu Microempresa</h1>
                <p>Crea ofertas de trabajo.</p>
            </section>
                
            <div id="contentSection">
                <!-- Job card principal -->
          

            <!-- Job cards dinámicas -->
            <?php while ($row = $result->fetch_assoc()): ?>
    <div class="job-card">
        <div class="job-header">
            <h1 class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></h1>
            <?php
            // Obtener el nombre de la empresa basado en el id_company del trabajo
            $companyQuery = "SELECT company_name FROM companies WHERE id_company = ?";
            $companyStmt = $conexion->prepare($companyQuery);
            $companyStmt->bind_param("i", $row['id_company']);
            $companyStmt->execute();
            $companyResult = $companyStmt->get_result();
            $companyName = $companyResult->fetch_assoc()['company_name'] ?? 'Empresa desconocida';
            ?>
            <p class="job-company">Empresa: <?php echo htmlspecialchars($companyName); ?></p>
            <div class="job-meta">
                <span class="job-meta-item"><i>📅</i> Publicado: <?php echo htmlspecialchars($row['published_job_date']); ?></span>
                <span class="job-meta-item"><i>⏳</i> Disponibilidad: <?php echo $row['duration_job'] ? 'Disponible' : 'No disponible'; ?></span>
                <span class="job-meta-item"><i>📍</i> Tipo de Trabajo: <?php echo htmlspecialchars($row['type_job']); ?></span>
                <span class="job-meta-item"><i>💲</i> <span class="job-salary"><?php echo htmlspecialchars($row['salary']); ?></span></span>
            </div>
        </div>
        <div class="job-category">
            <span class="category-label">Categoría:</span>
            <?php
            // Obtener el nombre de la categoría basado en el id
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
        <span>Válida hasta: <?php echo htmlspecialchars(date('Y-m-d', strtotime($row['time_limit']))); ?></span>
        
        </div>
    </div>
<?php endwhile; ?>
        </div>
    </main>
                  <!-- Contenido Principal -->

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
                                <div class="company-name">Tacos</div>
                                <div class="job-title">Necesito tacos</div>
                            </div>
                            <button class="view-button" id="verPerfil">Ver</button>
                        </div>
                <div class="contract-actions">
                <button class="view-button aceptar" id="aceptar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.97a.75.75 0 0 0 1.06 0l3.992-3.992a.75.75 0 0 0-1.06-1.06L7.5 9.44 5.53 7.47a.75.75 0 0 0-1.06 1.06l2.5 2.5z"/>
                    </svg>
                </button></svg></button>
                <button class="view-button rechazar" id="rechazar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                    </svg>
                </button></svg></button>
            <button class="view-button likert" id="calificar">
                <img src="../assets/like-right-svgrepo-com.svg" width="25" height="25" alt="Like Icon" style="filter: invert(100%);">
            </button>
            </div>
            </div>
            <!-- Repetir elementos dinamicos para demostrar el scroll -->
        
            <?php if ($resultRequests->num_rows > 0): ?>
    <div class="contracts-container">
        <?php while ($row = $resultRequests->fetch_assoc()): ?>
            <div class="contract-item">
                <div>
                    <div class="company-name"><?php echo htmlspecialchars($row['studen_name']); ?></div>
                    <div class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></div>
                    <div class="job-title"><?php echo htmlspecialchars($row['id_requests']); ?></div>
                </div>
                <button
                    class="view-button"
                    data-action="verPerfil"
                    data-id-request="<?php echo htmlspecialchars($row['id_requests']); ?>"
                    data-id-job="<?php echo htmlspecialchars($row['id_job']); ?>"
                    data-id-company="<?php echo htmlspecialchars($row['id_company']); ?>"
                    data-id-student="<?php echo htmlspecialchars($row['id_student']); ?>"
                >Ver</button>
            </div>
            <div class="contract-actions">
                <button
                    class="view-button aceptar"
                    data-action="aceptar"
                    data-id-request="<?php echo htmlspecialchars($row['id_requests']); ?>"
                    data-id-job="<?php echo htmlspecialchars($row['id_job']); ?>"
                    data-id-company="<?php echo htmlspecialchars($row['id_company']); ?>"
                    data-id-student="<?php echo htmlspecialchars($row['id_student']); ?>"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.97a.75.75 0 0 0 1.06 0l3.992-3.992a.75.75 0 0 0-1.06-1.06L7.5 9.44 5.53 7.47a.75.75 0 0 0-1.06 1.06l2.5 2.5z"/>
                    </svg>
                </button>
                <button
                    class="view-button rechazar"
                    data-action="rechazar"
                    data-id-request="<?php echo htmlspecialchars($row['id_requests']); ?>"
                    data-id-job="<?php echo htmlspecialchars($row['id_job']); ?>"
                    data-id-company="<?php echo htmlspecialchars($row['id_company']); ?>"
                    data-id-student="<?php echo htmlspecialchars($row['id_student']); ?>"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                    </svg>
                </button>
                <button
                    class="view-button likert"
                    data-action="calificar"
                    data-id-request="<?php echo htmlspecialchars($row['id_requests']); ?>"
                    data-id-job="<?php echo htmlspecialchars($row['id_job']); ?>"
                    data-id-company="<?php echo htmlspecialchars($row['id_company']); ?>"
                    data-id-student="<?php echo htmlspecialchars($row['id_student']); ?>"
                >
                    <img src="../assets/like-right-svgrepo-com.svg" width="25" height="25" alt="Like Icon" style="filter: invert(100%);">
                </button>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No hay contratos disponibles.</p>
<?php endif; ?>
            
         
               <!-- Más elementos... (repetir estructura según necesidad) -->



        </div>
    </div>



</div>
         <!-- Columna Derecha -->
       
    </div>

    <!-- Botón para abrir la ventana modal -->
<div class="add-button-container">
    <button class="add-button" id="openModalButton">+</button>
</div>

<!-- Ventana modal -->
 <!-- Ventana modal -->
  <!-- Ventana modal -->
   <!-- Ventana modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <span class="close-button" id="closeModalButton">&times;</span>
        <h2>Agregar Nueva Oferta</h2>
        <form id="jobForm">
            <label for="job-title">Título del empleo:</label>
            <input type="text" id="job-title" name="job-title" placeholder="Ejemplo: Desarrollador Frontend Senior" required>
            
            <!-- <label for="job-company">Nombre de la empresa:</label> -->
                 <!-- <label for="job-company">Nombre de la empresa:</label> -->
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
            <input type="text" id="job-salary" name="job-salary" placeholder="Ejemplo: $3,500/mes" required>
            
            <label for="job-duration">¿Está disponible el trabajo?</label>
            <select id="job-duration" name="job-duration" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>

            
            <label for="job-duration">Tiempo limite:</label>
            <input type="date" id="time-limit" name="time-limit" placeholder="Ejemplo: Hasta el 15 de mayo" required>
            
            <label for="job-location">Ubicación:</label>
            <input type="text" id="job-location" name="job-location" placeholder="Ejemplo: Remoto" required>
            
            <label for="job-requirements">Requisitos:</label>
            <textarea id="job-requirements" name="job-requirements" placeholder="Ejemplo: 5+ años de experiencia, React.js, APIs REST..." required></textarea>
            
            <label for="job-description">Descripción:</label>
            <textarea id="job-description" name="job-description" placeholder="Escribe una breve descripción del empleo..." required></textarea>
            
            <button type="submit" class="submit-button">Guardar</button>
        </form>
    </div>
</div>

<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css " rel="stylesheet">
    <script src="./contratoGestion.js" ></script>
    <script src="./scriptCDashboard.js"></script>
<link rel="stylesheet" href="../student-profile/styleSProfile.css">
</body>
</html>