<?php
header('Content-Type: application/json');
require_once('../database/conexion.php');

session_start();

// 1. Verificar si se proporcionó el parámetro request_id
if (!isset($_GET['request_id'])) {
    echo json_encode(["error" => "Se requiere el parámetro 'request_id'."]);
    exit();
}

$requestId = intval($_GET['request_id']);

// 2. Obtener el ID del estudiante basado en el ID de solicitud
$query = "SELECT id_student FROM requests WHERE id_requests = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    echo json_encode(["error" => "Error al preparar la consulta: " . $conexion->error]);
    $conexion->close();
    exit();
}

$stmt->bind_param("i", $requestId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "No se encontró ninguna solicitud con ID: " . $requestId]);
    $stmt->close();
    $conexion->close();
    exit();
}

$row = $result->fetch_assoc();
$studentId = $row['id_student'];
$stmt->close();

// 3. Validar el ID del estudiante
if ($studentId <= 0) {
    echo json_encode(["error" => "ID de estudiante no válido: " . $studentId]);
    $conexion->close();
    exit();
}

// Inicializar el array principal que contendrá todos los datos del estudiante
$studentData = [];

// --- Consulta a la tabla 'student' ---
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
    echo json_encode(["error" => "No se encontró ningún estudiante con ID: " . $studentId]);
    $stmtStudent->close();
    $conexion->close();
    exit();
}
$stmtStudent->close();

// --- Consulta a la tabla 'student_address' ---
$stmtAddress = $conexion->prepare("SELECT * FROM student_address WHERE id_student = ?");
if (!$stmtAddress) {
    echo json_encode(["error" => "Error al preparar la consulta de dirección: " . $conexion->error]);
    $conexion->close();
    exit();
}
$stmtAddress->bind_param("i", $studentId);
$stmtAddress->execute();
$resultAddress = $stmtAddress->get_result();
$address = $resultAddress->fetch_assoc();

if ($address) {
    $studentData['address'] = $address;
} else {
    $studentData['address'] = null;
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
    $courses[] = $row;
}
$studentData['courses_taken'] = $courses;
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
    $jobHistory[] = $row;
}
$studentData['job_history'] = $jobHistory;
$stmtJobHistory->close();

// 5. Cerrar la conexión final
$conexion->close();

// 6. Devolver los datos combinados como JSON
$jsonOutput = json_encode($studentData, JSON_PRETTY_PRINT);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Error al codificar JSON: " . json_last_error_msg()]);
} else {
    echo $jsonOutput;
}
