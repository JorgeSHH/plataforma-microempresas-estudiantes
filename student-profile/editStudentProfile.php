<?php 
session_start();
require_once('../database/conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login/login.php');
    exit();
}

// Verificar el rol del usuario
if ($_SESSION['user_rol'] !== 'estudiante') {
    header('Location: ../index.php');
    exit();
}

// Obtener los datos actuales del estudiante desde la base de datos
$userId = $_SESSION['user_id'];
$queryStudent = "SELECT * FROM student WHERE id_student = ?";
$stmtStudent = $conexion->prepare($queryStudent);
$stmtStudent->bind_param("i", $userId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$student = $resultStudent->fetch_assoc();

$queryAddress = "SELECT * FROM student_address WHERE id_student = ?";
$stmtAddress = $conexion->prepare($queryAddress);
$stmtAddress->bind_param("i", $userId);
$stmtAddress->execute();
$resultAddress = $stmtAddress->get_result();
$address = $resultAddress->fetch_assoc();

$student = array_merge($student, $address);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil del Estudiante</title>
    <link rel="stylesheet" href="./styleSProfile.css">
</head>
<body>
    <div class="container">
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
                    <a href="../database/logout.php" class="menu-link">
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
            <div class="company-card-container">
                <div class="company-card-E">
                    <h1>Editar Perfil del Estudiante</h1>
                    <form method="POST" action="updateStudentProfile.php" enctype="multipart/form-data">
                        <!-- Campo para cambiar la foto de perfil -->
                        <label for="img_profile" >Foto de Perfil:</label>
                        <input type="file" id="img_profile" name="img_profile" accept="image/*" onchange="setImageType()">
                        <input class="submit-button" type="hidden" id="img_profile_type" name="img_profile_type" value="" >

                        <script>
                            function setImageType() {
                                const fileInput = document.getElementById('img_profile');
                                const hiddenInput = document.getElementById('img_profile_type');
                                if (fileInput.files.length > 0) {
                                    const fileType = fileInput.files[0].type;
                                    if (fileType === 'image/jpeg' || fileType === 'image/jpg') {
                                        hiddenInput.value = 'jpg';
                                    } else {
                                        hiddenInput.value = '';
                                    }
                                }
                            }
                        </script>

                        <label for="student_name">Nombre:</label>
                        <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student['studen_name']); ?>" required minlength="3" maxlength="30">

                        <label for="student_lastname">Apellido:</label>
                        <input type="text" id="student_lastname" name="student_lastname" value="<?php echo htmlspecialchars($student['student_lastname']); ?>" required minlength="3" maxlength="30">

                        <label for="student_email">Correo Electrónico:</label>
                        <input type="email" id="student_email" name="student_email" value="<?php echo htmlspecialchars($student['student_email']); ?>" required minlength="6" maxlength="45">

                        <label for="student_phone">Teléfono:</label>
                        <input type="text" id="student_phone" name="student_phone" value="<?php echo htmlspecialchars($student['student_phone']); ?>" required minlength="3" maxlength="11">

                        <label for="student_identy_card">Cédula:</label>
                        <input type="text" id="student_identy_card" name="student_identy_card" value="<?php echo htmlspecialchars($student['student_identy_card']); ?>" required minlength="7" maxlength="8">

                        <label for="student_sex">Género:</label>
                        <select id="student_sex" name="student_sex" required>
                            <option value="Hombre" <?php echo ($student['student_sex'] === 'Hombre') ? 'selected' : ''; ?>>Hombre</option>
                            <option value="Mujer" <?php echo ($student['student_sex'] === 'Mujer') ? 'selected' : ''; ?>>Mujer</option>
                        </select>

                        <label for="date_of_birth">Fecha de Nacimiento:</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($student['date_of_birth']); ?>" required>

                        <label for="job-category">Categoría:</label>
                        <select id="job-category" name="job-category" required>
                            <option value="Tecnología e innovación" <?php echo ($student['job_preferences'] === '1') ? 'selected' : ''; ?>>Tecnología e innovación</option>
                            <option value="Marketing y publicidad" <?php echo ($student['job_preferences'] === '2') ? 'selected' : ''; ?>>Marketing y publicidad</option>
                            <option value="Recursos humanos" <?php echo ($student['job_preferences'] === '3') ? 'selected' : ''; ?>>Recursos humanos</option>
                            <option value="Educación y formación" <?php echo ($student['job_preferences'] === '4') ? 'selected' : ''; ?>>Educación y formación</option>
                            <option value="Salud y bienestar" <?php echo ($student['job_preferences'] === '5') ? 'selected' : ''; ?>>Salud y bienestar</option>
                            <option value="Logística y transporte" <?php echo ($student['job_preferences'] === '6') ? 'selected' : ''; ?>>Logística y transporte</option>
                        </select>

                        <label for="summary">Resumen Profesional:</label>
                        <textarea id="summary" name="summary" required><?php echo htmlspecialchars($student['summary']); ?></textarea>

                        <label for="education_level">Nivel de Educación:</label>
                        <input type="text" id="education_level" name="education_level" value="<?php echo htmlspecialchars($student['education_level']); ?>" required>

                        <label for="portfolio">Portafolio:</label>
                        <input type="text" id="portfolio" name="portfolio" value="<?php echo htmlspecialchars($student['portfolio']); ?>">

                        <label for="curriculum_vitae">Curriculum Vitae:</label>
                        <input type="text" id="curriculum_vitae" name="curriculum_vitae" value="<?php echo htmlspecialchars($student['curriculum_vitae']); ?>">

                        <label for="state">Estado:</label>
                        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($student['state']); ?>" required>

                        <label for="parish">Parroquia:</label>
                        <input type="text" id="parish" name="parish" value="<?php echo htmlspecialchars($student['parish']); ?>" required>

                        <label for="sector">Sector:</label>
                        <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($student['sector']); ?>" required>

                        <label for="street">Calle:</label>
                        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($student['street']); ?>" required>

                        <button type="submit" class="submit-button">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="./scriptSProfile.js"></script>
</body>
</html>