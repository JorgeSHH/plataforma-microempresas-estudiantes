<?php
header('Content-Type: application/json'); // Indicate that the response will be JSON

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit();
}

// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'platafordb');

// Create database connection
$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conexion->connect_error) {
    // Log the error internally, but provide a generic message to the client
    error_log("Error de conexión a la base de datos: " . $conexion->connect_error);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

// Get the request body (JSON)
$json_data = file_get_contents('php://input');

// Decode to an associative array
$data = json_decode($json_data, true);

// Verify if decoding was successful and if the necessary data exists
// Note: idRequest is not used in your INSERT statement, so it's not strictly "necessary" for the DB operation itself
// but it's good to validate all expected input.
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['idRequest'], $data['idJob'], $data['idCompany'], $data['idStudent'], $data['rating'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos o formato incorrecto.']);
    exit();
}

// Retrieve the data
// Cast to appropriate types for safety and consistency with database schema
$idRequest = (int)$data['idRequest']; // Assuming integer
$idJob = (int)$data['idJob'];         // Assuming integer
$idCompany = (int)$data['idCompany']; // Assuming integer
$idStudent = (int)$data['idStudent']; // Assuming integer
$rating = (float)$data['rating'];     // Ensure it's a float

try {
    // Correct SQL query: only 4 placeholders needed as review is the only value for id_request is not in table and rating is going to review
    $stmt = $conexion->prepare("INSERT INTO job_review (id_student, id_company, id_job, review) VALUES (?, ?, ?, ?)");
    
    // Check if the prepare statement failed
    if ($stmt === false) {
        error_log("Error al preparar la consulta: " . $conexion->error);
        echo json_encode(['success' => false, 'message' => 'Error interno del servidor al preparar la operación.']);
        $conexion->close();
        exit();
    }

    // Correct bind_param: 'i' for integers, 'd' for double/float
    $stmt->bind_param("iiid", $idStudent, $idCompany, $idJob, $rating);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Calificación registrada exitosamente.']);
    } else {
        // If affected_rows is 0, it means no rows were inserted. This could be due to a unique constraint,
        // or if the query somehow didn't result in an insert.
        echo json_encode(['success' => false, 'message' => 'No se pudo registrar la calificación o ya existía.']);
    }
    $stmt->close();
} catch (Exception $e) {
    error_log("Error al insertar calificación: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor al guardar la calificación.']);
} finally {
    // Ensure the connection is closed in all cases
    $conexion->close();
}
?>