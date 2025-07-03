<?php
header('Content-Type: application/json');

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'platafordb');

if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conexion->connect_error]);
    exit;
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Asegurarse de que los datos necesarios están presentes
if (!isset($data['idRequest'], $data['idJob'], $data['idStudent'], $data['idCompany'])) { // Agregué idCompany aquí
    echo json_encode(['success' => false, 'message' => 'Datos incompletos en la solicitud. Asegúrate de enviar idRequest, idJob, idStudent y idCompany.']);
    $conexion->close();
    exit;
}

// Extraer datos y sanitizarlos (¡MUY IMPORTANTE!)
// Usamos prepared statements para mayor seguridad
$idRequest = (int)$data['idRequest'];
$idJob = (int)$data['idJob'];
$idStudent = (int)$data['idStudent'];
// $idCompany = (int)$data['idCompany']; // idCompany no se usa directamente en las consultas, pero se recibe.

// Iniciar transacción
$conexion->begin_transaction();

try {
    // 1. Actualizar estado de la solicitud
    $stmt1 = $conexion->prepare("UPDATE requests SET state = 'aprobado' WHERE id_requests = ?");
    $stmt1->bind_param("i", $idRequest);
    $stmt1->execute();
    $stmt1->close();

    // 2. Actualizar duration_job (asumiendo que 0 significa "completado" o "ya no disponible")
    $stmt2 = $conexion->prepare("UPDATE jobs SET duration_job = 0 WHERE id_job = ?");
    $stmt2->bind_param("i", $idJob);
    $stmt2->execute();
    $stmt2->close();
    
    // 3. Crear nuevo contrato
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+6 months'));
    
    $stmt3 = $conexion->prepare("INSERT INTO contracts (contract_start_date, contract_end_date, id_job, id_student) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("ssii", $startDate, $endDate, $idJob, $idStudent);
    $stmt3->execute();
    $stmt3->close();
    
    // Confirmar cambios
    $conexion->commit();
    echo json_encode(['success' => true, 'message' => 'Operación completada exitosamente.']);
    
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conexion->rollback();
    error_log("Error en la operación de aceptación: " . $e->getMessage()); // Registra el error para depuración
    echo json_encode(['success' => false, 'message' => 'Error en la operación: ' . $e->getMessage()]);
} finally {
    $conexion->close();
}                                                                                       