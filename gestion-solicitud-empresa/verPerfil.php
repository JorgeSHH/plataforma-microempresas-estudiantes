<?php
header('Content-Type: application/json'); // Indica al navegador que la respuesta es JSON
require_once('../database/conexion.php');

session_start();

// 1. Obtener el ID del estudiante (aquí lo fijamos para pruebas, pero en un entorno real vendría de $_GET o $_POST)
//studentId = $_SESSION['user_id'];

$studentId = 22;

// 2. Validar el ID del estudiante
if ($studentId === 0) {
    echo json_encode(["error" => "Se requiere el ID del estudiante."]);
    $conexion->close();
    exit();
}

// Inicializar el array principal que contendrá todos los datos del estudiante
$studentData = [];

// --- Consulta a la tabla 'student' ---
// Selecciona solo las columnas que NO contienen datos binarios como la imagen
$stmtStudent = $conexion->prepare("SELECT id_student, studen_name, student_lastname, student_identy_card, student_email, student_password, student_skills, education_level, job_preferences, student_phone, date_of_birth, student_sex, portfolio, curriculum_vitae, role_id, img_perfil_type FROM student WHERE id_student = ?");

if (!$stmtStudent) {
    echo json_encode(["error" => "Error al preparar la consulta de estudiante: " . $conexion->error]);
    $conexion->close();
    exit();
}

$stmtStudent->bind_param("i", $studentId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();

if ($resultStudent->num_rows > 0) {
    $studentData = $resultStudent->fetch_assoc();
} else {
    // Si no se encuentra el estudiante, devolver un error y terminar
    echo json_encode(["error" => "No se encontró ningún estudiante con ID: " . $studentId]);
    $stmtStudent->close();
    $conexion->close();
    exit();
}
$stmtStudent->close(); // Cierra el statement de student

// --- Consulta a la tabla 'student_address' ---
$stmtAddress = $conexion->prepare("SELECT * FROM student_address WHERE id_student = ?");
if (!$stmtAddress) {
    // Es importante manejar errores en cada preparación
    echo json_encode(["error" => "Error al preparar la consulta de dirección: " . $conexion->error]);
    $conexion->close();
    exit();
}
$stmtAddress->bind_param("i", $studentId);
$stmtAddress->execute();
$resultAddress = $stmtAddress->get_result();
$address = $resultAddress->fetch_assoc(); // Asume que un estudiante tiene una única dirección

// Combina los datos de dirección directamente en $studentData
if ($address) {
    $studentData['address'] = $address; // Añade un sub-objeto 'address'
} else {
    $studentData['address'] = null; // O un array vacío, según tu preferencia
}
$stmtAddress->close();

// --- Consulta a la tabla 'courses_taken' ---
$stmtCourses = $conexion->prepare("SELECT * FROM courses_taken WHERE id_student = ?");
if (!$stmtCourses) {
    echo json_encode(["error" => "Error al preparar la consulta de cursos: " . $conexion->error]);
    $conexion->close();
    exit();
}
$stmtCourses->bind_param("i", $studentId);
$stmtCourses->execute();
$resultCourses = $stmtCourses->get_result();
$courses = [];
while ($row = $resultCourses->fetch_assoc()) {
    $courses[] = $row; // Almacena todos los cursos como un array de objetos
}
$studentData['courses_taken'] = $courses; // Añade un array de cursos
$stmtCourses->close();

// --- Consulta a la tabla 'job_history' ---
$stmtJobHistory = $conexion->prepare("SELECT * FROM job_history WHERE id_student = ?");
if (!$stmtJobHistory) {
    echo json_encode(["error" => "Error al preparar la consulta de historial de trabajo: " . $conexion->error]);
    $conexion->close();
    exit();
}
$stmtJobHistory->bind_param("i", $studentId);
$stmtJobHistory->execute();
$resultJobHistory = $stmtJobHistory->get_result();
$jobHistory = [];
while ($row = $resultJobHistory->fetch_assoc()) {
    $jobHistory[] = $row; // Almacena todos los trabajos como un array de objetos
}
$studentData['job_history'] = $jobHistory; // Añade un array de historial de trabajo
$stmtJobHistory->close();

// 4. Cerrar la conexión final
$conexion->close();

// 5. Devolver los datos combinados como JSON
$jsonOutput = json_encode($studentData, JSON_PRETTY_PRINT);

// Verifica si la codificación JSON fue exitosa
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Error al codificar JSON: " . json_last_error_msg()]);
} else {
    echo $jsonOutput;
}
