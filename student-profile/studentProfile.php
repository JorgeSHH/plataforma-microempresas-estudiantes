<?php 
session_start();
require_once('../database/conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Verificar el rol del usuario
if ($_SESSION['user_rol'] !== 'estudiante') {
    header('Location: ../index.php');
    exit();
}

// Obtener el ID del estudiante desde la sesión
$userId = $_SESSION['user_id'];

// Obtener datos de la tabla student
$queryStudent = "SELECT * FROM student WHERE id_student = ?";
$stmtStudent = $conexion->prepare($queryStudent);
$stmtStudent->bind_param("i", $userId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$student = $resultStudent->fetch_assoc();

// Obtener datos de la tabla student_address
$queryAddress = "SELECT * FROM student_address WHERE id_student = ?";
$stmtAddress = $conexion->prepare($queryAddress);
$stmtAddress->bind_param("i", $userId);
$stmtAddress->execute();
$resultAddress = $stmtAddress->get_result();
$address = $resultAddress->fetch_assoc();

// Obtener datos de la tabla courses_taken
$queryCourses = "SELECT * FROM courses_taken WHERE id_student = ?";
$stmtCourses = $conexion->prepare($queryCourses);
$stmtCourses->bind_param("i", $userId);
$stmtCourses->execute();
$resultCourses = $stmtCourses->get_result();
$courses = [];
while ($row = $resultCourses->fetch_assoc()) {
    $courses[] = $row;
}

// Obtener datos de la tabla job_history
$queryJobHistory = "SELECT * FROM job_history WHERE id_student = ?";
$stmtJobHistory = $conexion->prepare($queryJobHistory);
$stmtJobHistory->bind_param("i", $userId);
$stmtJobHistory->execute();
$resultJobHistory = $stmtJobHistory->get_result();
$jobHistory = [];
while ($row = $resultJobHistory->fetch_assoc()) {
    $jobHistory[] = $row;
}

// Combinar datos de todas las tablas
$student = array_merge($student, $address, ['courses_taken' => $courses], ['job_history' => $jobHistory]);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Profesional</title>
    <link rel="stylesheet" href="./styleSProfile.css">
   
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
                <img src="../assets/logo2.png" alt="Logo">
            </div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="../index.php" class="menu-link" ondblclick="window.location.href='../student-dashboard/studentDashboard.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                        </svg>    
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>
         
                <li class="menu-item">
                <div class="menu-link" ondblclick="window.location.href='../student-profile/studentProfile.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span class="menu-text">Perfil</span>
                    </a>
                </li>
                <li class="menu-item">
                <a href="'../index.php';" class="menu-link" ondblclick="window.location.href='../index.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
            
        </nav>
        
        <!-- Contenido principal con el curriculum -->
        <main class="main-content" id="mainContent">
            <div class="cv-container">
                <header class="cv-header">
                    <div class="header-content">
                        <div class="profile-pic">
                        <?php
                            if (!empty($student['img_profile'])) {
                                $imgData = base64_encode($student['img_profile']);
                                echo '<img src="data:image/jpeg;base64,' . $imgData . '" alt="Logo del estudiante" id="company-logo-img">';
                            } else {
                                echo '<img src="../assets/default-logo.png" alt="Logo por defecto" id="company-logo-img">';
                            }
                            ?>
                        </div>
                        <div class="header-text">
                        <h1 class="company-name"><?php echo htmlspecialchars($student['studen_name'] . ' ' . $student['student_lastname']); ?></h1>
                            <div class="contact-info">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg> <?php echo htmlspecialchars($student['student_email']); ?></p>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                    </svg> <?php echo htmlspecialchars($student['student_phone']); ?></p>
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                                        <path d="M14 4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h12zm0-1H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                                        <path d="M3 8h10v1H3V8zm0-2h10v1H3V6z"/>
                                    </svg> <?php echo htmlspecialchars($student['student_identy_card']); ?></p>
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-ambiguous" viewBox="0 0 16 16">
                                            <path d="M9.5 2a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0zM8 4a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM8 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0zM8 6a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                        </svg> <?php echo htmlspecialchars($student['student_sex']); ?>
                                    </p>
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 1 0V1zm11 3H1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3z"/>
                                            <path d="M2.5 4a.5.5 0 0 1 .5.5v.5h10v-.5a.5.5 0 0 1 1 0v.5a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-.5a.5.5 0 0 1 .5-.5z"/>
                                        </svg> <?php echo htmlspecialchars(date('Y-m-d', strtotime($student['date_of_birth']))); ?>
                                    </p>
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                        <path d="M6.5 0a1.5 1.5 0 0 0-1.5 1.5V2H1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-4V1.5A1.5 1.5 0 0 0 9.5 0h-3zm0 1h3a.5.5 0 0 1 .5.5V2h-4v-.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg> <?php echo htmlspecialchars($student['job_preferences']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </header>
                
<!-- informacion general de la cuenta del estudiante -->
                <div class="cv-content">
                    <div class="left-column">
                        <section class="cv-section about">
                            <h3><i class="fas fa-user"></i> Sobre mí</h3>
                            <p><?php echo htmlspecialchars($student['summary']); ?></p>
                            
                        </section>
                        <section class="cv-section">
                            <h3><i class="fas fa-code"></i> Dirección</h3>
                            <ul class="responsibilities">
                                <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94C12.166 11.5 8 15 8 15s-4.166-3.5-4.166-6.06a4.166 4.166 0 1 1 8.332 0zM8 8.166a1.666 1.666 0 1 0 0-3.332 1.666 1.666 0 0 0 0 3.332z"/>
                                    </svg> 
                                    <b>Calle:</b> <?php echo htmlspecialchars($student['street']); ?>
                                </p>
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                        <path d="M4 1a1 1 0 0 0-1 1v13h1v-2h8v2h1V2a1 1 0 0 0-1-1H4zm1 1h6v2H5V2zm0 3h6v2H5V5zm0 3h6v2H5V8zm0 3h6v2H5v-2z"/>
                                    </svg> 
                                    <b>Sector:</b> <?php echo htmlspecialchars($student['sector']); ?>
                                </p>
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                        <path d="M15.817.113A.5.5 0 0 1 16 .5v13a.5.5 0 0 1-.683.464L10 12.118l-4.317 1.846a.5.5 0 0 1-.366 0L.183 13.887A.5.5 0 0 1 0 13.5v-13a.5.5 0 0 1 .683-.464L6 3.882l4.317-1.846a.5.5 0 0 1 .366 0l5.134 2.177zM10 11.882l4 1.714V1.618l-4-1.714v11.978zM6 4.118L2 2.404v11.978l4-1.714V4.118z"/>
                                    </svg> 
                                    <b>Parroquia:</b> <?php echo htmlspecialchars($student['parish']); ?>
                                </p>
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94C12.166 11.5 8 15 8 15s-4.166-3.5-4.166-6.06a4.166 4.166 0 1 1 8.332 0zM8 8.166a1.666 1.666 0 1 0 0-3.332 1.666 1.666 0 0 0 0 3.332z"/>
                                    </svg> 
                                    <b>Estado:</b> <?php echo htmlspecialchars($student['state']); ?>
                                </p></svg>
                            </ul>
                        </section>

                        <section class="cv-section education">
                            <h3><i class="fas fa-graduation-cap"></i> Cursos Realizados</h3>
                            <?php if (!empty($student['courses_taken'])): ?>
                                <ul>
                                    <?php foreach ($student['courses_taken'] as $course): ?>
                                        <li>
                                            <ul>
                                                <li><strong>Nombre del Curso:</strong> <?php echo htmlspecialchars($course['name_curso']); ?></li>
                                                <li><strong>Institución:</strong> <?php echo htmlspecialchars($course['institution']); ?></li>
                                                <li><strong>Duración:</strong> <?php echo htmlspecialchars($course['duration']); ?></li>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No se han registrado cursos.</p>
                            <?php endif; ?>


                            
                    </div>

                                


                    <div class="right-column">
                        <section class="cv-section experience">
                            <h3><i class="fas fa-briefcase"></i> Mis Habilidades</h3>
                            <?php
                            if (!empty($student['student_skills'])) {
                                $skills = explode(',', $student['student_skills']);
                                echo '<ul>';
                                foreach ($skills as $skill) {
                                    echo '<li>' . htmlspecialchars(trim($skill)) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No se han registrado habilidades.</p>';
                            }
                            ?>
                        </section>

                        <section class="cv-section projects">
                            <h3><i class="fas fa-project-diagram"></i> Documentos Profesionales</h3>
                            <ul class="responsibilities">
                                <li class="cv-item">
                                    <h4>
                                    <p>
                                        <a href="<?php echo htmlspecialchars($student['portfolio']); ?>" target="_blank">Portafolio</a>
                                    </p>
                                    <p>
                                        <a href="<?php echo htmlspecialchars($student['curriculum_vitae']); ?>" target="_blank">Curriculum Vitae</a>
                                    </p></h4>
                                </li>
                            </ul>
                        </section>

                        <section class="cv-section education">
                            <h3><i class="fas fa-graduation-cap"></i>Nivel de Educación</h3>
                            <div class="cv-item">
                                <h4>Nivel más alto de educación alcanzado</h4>
                                <p><?php echo htmlspecialchars($student['education_level']); ?></p>
                                </p>
                            </div>

                        </section>

                        <section class="cv-section education">
                            <h3><i class="fas fa-briefcase"></i> Historial de Trabajos</h3>
                            <?php if (!empty($student['job_history'])): ?>
                                <ul>
                                    <?php foreach ($student['job_history'] as $job): ?>
                                        <li>
                                            <ul>
                                                <li><strong>Empresa:</strong> <?php echo htmlspecialchars($job['company']); ?></li>
                                                <li><strong>Posición:</strong> <?php echo htmlspecialchars($job['job_position']); ?></li>
                                                <li><strong>Periodo:</strong> <?php echo htmlspecialchars($job['period']); ?></li>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No se ha registrado historial de trabajos.</p>
                            <?php endif; ?>
                        </section>

                     
                    </div>
                </div>
       <!-- Botón para editar el perfil -->
       <div class="edit-profile-button-container">
                            <a href="editStudentProfile.php" class="edit-profile-button">Editar Perfil</a>
                        </div>
                
            </div>
        </main>
    </div>
<!-- //footer -->
<footer>



    <script src="./scriptSProfile.js"></script>
</body>
</html>