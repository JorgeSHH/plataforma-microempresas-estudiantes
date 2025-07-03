<?php

require_once '../database/conexion.php';

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login/login.php'); 
    exit();
}

// Opcional: Verificar el rol si la página es específica para un rol
if ($_SESSION['user_rol'] !== 'estudiante') {
    // Redirigir a una página de acceso denegado o al dashboard principal
    header('Location: ../index.php'); // O dashboard_empresa.php si es empresa
    exit();
}

// Consultar las ofertas de trabajo desde la base de datos
// Ahora usamos `duration_job` en lugar de `available`

$query = "SELECT jobs.*, companies.company_name 
          FROM jobs 
          INNER JOIN companies ON jobs.id_company = companies.id_company";
$result = $conexion->query($query);


// Obtener datos de la tabla students
$userId = $_SESSION['user_id']; // Asegúrate de que 'user_id' esté configurado en la sesión al iniciar sesión
$queryStudent = "SELECT * FROM student WHERE id_student = ?";
$stmtStudent = $conexion->prepare($queryStudent);
if (!$stmtStudent) {
    // Manejar error de preparación de consulta
    die("Error al preparar la consulta de estudiante: " . $conexion->error);
}
$stmtStudent->bind_param("i", $userId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$student = $resultStudent->fetch_assoc();
$stmtStudent->close(); // Cerrar el statement del estudiante
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Desplegable</title>
    <link rel="stylesheet" href="./styleDashboar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container-menu">
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
                    <a href="../index.php" class="menu-link" ondblclick="window.location.href='../index.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                        </svg>    
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#propuestas" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                            <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                        </svg>
                        <span class="menu-text">Propuestas realizadas</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div class="menu-link" ondblclick="window.location.href='../student-profile/studentProfile.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span class="menu-text">Perfil</span>
                    </div>
                </li>
                <li class="menu-item">
                <a href="../database/logout.php" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <main class="main-content" id="mainContent">
            <div class="profile-header">
                <div class="profile-info">
                    <?php
                    if (!empty($student['img_profile'])) {
                        $imgData = base64_encode($student['img_profile']);
                        $imgType = $student['img_perfil_type'] ?? 'image/jpeg'; // Fallback a jpeg si no está definido
                        echo '<img src="data:' . htmlspecialchars($imgType) . ';base64,' . $imgData . '" alt="Foto de perfil" class="profile-pic">';
                    } else {
                        echo '<img src="../assets/default-logo.png" alt="Foto de perfil por defecto" class="profile-pic">';
                    }
                    ?>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($student['studen_name']); ?></div> 
                        <div class="user-handle"><?php echo htmlspecialchars($student['student_email']); ?></div>
                    </div>
                </div>
            </div>
            <section class="welcome">
                <h1>Bienvenido, Estudiante</h1>
                <p>Vamos a encontrar ofertas de trabajo.</p>
            </section>
                
            <div id="contentSection">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="job-card" data-category="<?php echo htmlspecialchars($row['id_job']); ?>">
                        <div class="job-header">
                            <h1 class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></h1>
                            <p class="job-company"><?php echo htmlspecialchars($row['company_name']); ?></p>
                            <div class="job-meta">
                                <span class="job-meta-item"><i>📅</i> Publicado: <?php echo htmlspecialchars($row['published_job_date']); ?></span>
                                <span class="job-meta-item"><i>⏳</i> Disponibilidad: <?php echo ($row['duration_job'] == 1) ? 'Disponible' : 'No disponible'; ?></span>
                                <span class="job-meta-item"><i>📍</i> Tipo de Trabajo: <?php echo htmlspecialchars($row['type_job']); ?></span>
                                <span class="job-meta-item"><i>💰</i> <span class="job-salary"><?php echo htmlspecialchars($row['salary']); ?></span></span>
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
                        <span>Válida hasta: <?php echo htmlspecialchars(date('Y-m-d', strtotime($row['time_limit']))); ?></span>
                            <button
                                class="apply-button btn-postular"
                                data-job-id="<?php echo htmlspecialchars($row['id_job']); ?>"
                                data-student-id="<?php echo htmlspecialchars($userId); ?>"
                                <?php echo ($row['duration_job'] == 0) ? 'disabled' : ''; ?> >
                                <?php echo ($row['duration_job'] == 0) ? 'No Disponible' : 'Postularse'; ?> </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
        
        <div class="sidebar-right">
            <form method="POST" action="studentDashboard.php">
                <div class="search-container">    
                    <input type="search" placeholder="Buscar..." name="buscar" />
                    <svg class="search-icon" viewBox="0 0 24 24" >
                        <path d="M15.5 14h-.79l-.28-.27a6.471 6.471 0 001.48-5.34C15.36 6.01 12.3 3 8.5 3S1.64 6.01 1.64 9.39c0 3.38 3.06 6.39 6.86 6.39 1.61 0 3.08-.59 4.19-1.56l.27.28v.79l5 4.99L20.49 19l-4.99-5zM8.5 14c-2.52 0-4.57-1.95-4.57-4.61S5.98 4.78 8.5 4.78s4.57 1.95 4.57 4.61S11.02 14 8.5 14z"/>
                    </svg>
                </div>
            </form>
            <div class="filters-section">
                <div class="filter-buttons-container" style="max-height: 240px; overflow-y: auto;">
                    <h3>Filtros de búsqueda</h3>
                    <button class="filter-button" data-category="1">
                        <i class="icon">💡</i> Tecnología e innovación
                    </button>
                    <button class="filter-button" data-category="2">
                        <i class="icon">📈</i> Marketing y publicidad
                    </button>
                    <button class="filter-button" data-category="3">
                        <i class="icon">👥</i> Recursos humanos
                    </button>
                    <button class="filter-button" data-category="4">
                        <i class="icon">📚</i> Educación y formación
                    </button>
                    <button class="filter-button" data-category="5">
                        <i class="icon">❤️</i> Salud y bienestar
                    </button>
                    <button class="filter-button" data-category="6">
                        <i class="icon">🚚</i> Logística y transporte
                    </button>
                    <button class="filter-button" data-category="all">
                        <i class="icon">🌍</i> Mostrar todos
                    </button>
                </div>
            </div>

            <div class="contracts-section">
                <div class="filter-buttons-container" style="max-height: 240px; overflow-y: auto;">
                    <h3>Contratos</h3>
                    <div class="contracts-container">
                        <div class="contract-item">
                            <div>
                                <div class="company-name">Nombre de la empresa</div>
                                <div class="job-title">Título del empleo</div>
                            </div>
                            <button class="view-button">Ver</button>
                        </div>
                        
                        <div class="contract-item">
                            <div>
                                <div class="company-name">Nombre de la empresa</div>
                                <div class="job-title">Título del empleo</div>
                            </div>
                            <button class="view-button">Ver</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <script src="../request/request.js"></script>
    <script src="./scriptDashboard.js"></script>
</body>
</html>