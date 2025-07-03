<?php
header('Content-Type: application/json');
require_once('../database/conexion.php');

$studentId = 23; // ID que estás probando

if ($studentId === 0) {
    echo json_encode(["error" => "Se requiere el ID del estudiante."]);
    $conexion->close();
    exit();
}

// 3. Preparar y ejecutar la consulta SQL
// ¡Selecciona solo las columnas que NO contienen datos binarios!
$stmt = $conexion->prepare("SELECT id_student, studen_name, student_lastname, student_identy_card, student_email, student_password, student_skills, education_level, job_preferences, student_phone, date_of_birth, student_sex, portfolio, curriculum_vitae, role_id, img_perfil_type FROM student WHERE id_student = ?"); // Asegúrate de que 'id_student' es el nombre correcto

if (!$stmt) {
    // Si la preparación de la consulta falla (ej. columna inexistente, error de sintaxis)
    echo json_encode(["error" => "Error al preparar la consulta: " . $conexion->error]);
    $conexion->close();
    exit();
}

$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

$studentData = [];

if ($result->num_rows > 0) {
    $studentData = $result->fetch_assoc();
} else {
    $studentData = ["error" => "No se encontró ningún estudiante con ID: " . $studentId];
}

$stmt->close();
$conexion->close();

// 5. Devolver los datos como JSON
$jsonOutput = json_encode($studentData, JSON_PRETTY_PRINT);

// Verifica si la codificación JSON fue exitosa
if (json_last_error() !== JSON_ERROR_NONE) {
    // Si hay un error al codificar a JSON, lo capturamos
    echo json_encode(["error" => "Error al codificar JSON: " . json_last_error_msg()]);
} else {
    echo $jsonOutput;
}

?>