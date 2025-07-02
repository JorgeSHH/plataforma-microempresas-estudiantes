<?php
require_once '../database/conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "No se pudo obtener el ID del usuario desde la sesión.";
    exit;
}

// Verificar el rol del usuario
if ($_SESSION['user_rol'] !== 'estudiante') {
    header('Location: ../index.php');
    exit();
}

// Obtener el ID del estudiante desde la sesión
$userId = $_SESSION['user_id'];

// Obtener los datos enviados desde el formulario
$studentName = $_POST['student_name'];
$studentLastname = $_POST['student_lastname'];
$studentEmail = $_POST['student_email'];
$studentPhone = $_POST['student_phone'];
$studentIdentyCard = $_POST['student_identy_card'];
$studentSex = $_POST['student_sex'];
$dateOfBirth = $_POST['date_of_birth'];
$jobPreferences = $_POST['job-category'];
$summary = $_POST['summary'];
$educationLevel = $_POST['education_level'];
$portfolio = $_POST['portfolio'];
$curriculumVitae = $_POST['curriculum_vitae'];

// Dirección
$state = $_POST['state'];
$parish = $_POST['parish'];
$sector = $_POST['sector'];
$street = $_POST['street'];

// Procesar la imagen de perfil si se subió
if (isset($_FILES['img_profile']) && $_FILES['img_profile']['error'] === UPLOAD_ERR_OK) {
    $imgData = file_get_contents($_FILES['img_profile']['tmp_name']);
    $imgType = $_POST['img_profile_type']; // Obtener el tipo de imagen del formulario

    // Actualizar la imagen de perfil y su tipo en la tabla `student`
    $queryImg = "UPDATE student SET img_profile = ?, img_perfil_type = ? WHERE id_student = ?";
    $stmtImg = $conexion->prepare($queryImg);
    if (!$stmtImg) {
        die("Error en la consulta: " . $conexion->error);
    }
    $stmtImg->bind_param("bsi", $imgData, $imgType, $userId);
    $stmtImg->send_long_data(0, $imgData); // Enviar datos binarios en partes pequeñas
    $stmtImg->execute();
    $stmtImg->close();
}

// Actualizar los datos en la tabla `student`
$queryStudent = "UPDATE student SET 
    studen_name = ?, 
    student_lastname = ?, 
    student_email = ?, 
    student_phone = ?, 
    student_identy_card = ?, 
    student_sex = ?, 
    date_of_birth = ?, 
    job_preferences = ?, 
    summary = ?, 
    education_level = ?, 
    portfolio = ?, 
    curriculum_vitae = ? 
WHERE id_student = ?";
$stmtStudent = $conexion->prepare($queryStudent);

if (!$stmtStudent) {
    die("Error en la consulta: " . $conexion->error);
}

$stmtStudent->bind_param(
    "ssssssssssssi",
    $studentName,
    $studentLastname,
    $studentEmail,
    $studentPhone,
    $studentIdentyCard,
    $studentSex,
    $dateOfBirth,
    $jobPreferences,
    $summary,
    $educationLevel,
    $portfolio,
    $curriculumVitae,
    $userId
);

if (!$stmtStudent->execute()) {
    die("Error al actualizar los datos del estudiante: " . $stmtStudent->error);
}
$stmtStudent->close();

// Actualizar los datos en la tabla `student_address`
$queryAddress = "UPDATE student_address SET 
    state = ?, 
    parish = ?, 
    sector = ?, 
    street = ? 
WHERE id_student = ?";
$stmtAddress = $conexion->prepare($queryAddress);

if (!$stmtAddress) {
    die("Error en la consulta: " . $conexion->error);
}

$stmtAddress->bind_param("ssssi", $state, $parish, $sector, $street, $userId);

if (!$stmtAddress->execute()) {
    die("Error al actualizar los datos de dirección: " . $stmtAddress->error);
}
$stmtAddress->close();

// Redirigir al perfil del estudiante con un mensaje de éxito
header('Location: studentProfile.php?success=1');
?>