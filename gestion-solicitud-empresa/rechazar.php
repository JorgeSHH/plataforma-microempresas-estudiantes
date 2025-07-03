<?php
header('Content-Type: application/json');
require_once('../database/conexion.php'); // Asegúrate de que esta ruta sea correcta y que la conexión sea válida
session_start();

// 1. Verificar si se proporcionó el parámetro request_id y es válido
if (!isset($_POST['request_id']) || !is_numeric($_POST['request_id'])) {
    echo json_encode(["error" => "Se requiere un ID de solicitud (request_id) válido para eliminar."]);
    exit();
}

$requestId = intval($_POST['request_id']);

if ($requestId <= 0) {
    echo json_encode(["error" => "ID de solicitud no válido."]);
    $conexion->close();
    exit();
}

// Iniciar una transacción para asegurar que ambas eliminaciones (contrato y solicitud) sean atómicas.
// Si una falla, ambas se revertirán.
$conexion->begin_transaction();

try {
    // 2. Obtener el ID del estudiante basado en el ID de solicitud
    $queryGetStudentId = "SELECT id_student FROM requests WHERE id_requests = ?";
    $stmtGetStudentId = $conexion->prepare($queryGetStudentId);

    if (!$stmtGetStudentId) {
        throw new Exception("Error al preparar la consulta para obtener el ID del estudiante: " . $conexion->error);
    }

    $stmtGetStudentId->bind_param("i", $requestId);
    $stmtGetStudentId->execute();
    $result = $stmtGetStudentId->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("No se encontró ninguna solicitud con ID: " . $requestId);
    }

    $row = $result->fetch_assoc();
    $studentId = $row['id_student'];
    $stmtGetStudentId->close();

    // 3. Obtener los ID de contratos asociados al id_student
    $queryGetContracts = "SELECT id_contract FROM contracts WHERE id_student = ?";
    $stmtGetContracts = $conexion->prepare($queryGetContracts);

    if (!$stmtGetContracts) {
        throw new Exception("Error al preparar la consulta para obtener los contratos: " . $conexion->error);
    }

    $stmtGetContracts->bind_param("i", $studentId);
    $stmtGetContracts->execute();
    $resultContracts = $stmtGetContracts->get_result();

    $contractIds = [];
    while ($rowContract = $resultContracts->fetch_assoc()) {
        $contractIds[] = $rowContract['id_contract'];
    }
    $stmtGetContracts->close();

    // 4. Eliminar los contratos asociados al id_student
    if (!empty($contractIds)) {
        $queryDeleteContracts = "DELETE FROM contracts WHERE id_contract IN (" . implode(',', $contractIds) . ")";
        $stmtDeleteContracts = $conexion->prepare($queryDeleteContracts);

        if (!$stmtDeleteContracts) {
            throw new Exception("Error al preparar la consulta de eliminación de contratos: " . $conexion->error);
        }

        $successDeleteContracts = $stmtDeleteContracts->execute();

        if (!$successDeleteContracts) {
            throw new Exception("Error al ejecutar la eliminación de contratos: " . $stmtDeleteContracts->error);
        }

        $contractsAffectedRows = $stmtDeleteContracts->affected_rows;
        $stmtDeleteContracts->close();
    } else {
        $contractsAffectedRows = 0; // No hay contratos para eliminar
    }

    // 5. Eliminar la solicitud de la tabla requests
    $queryDeleteRequest = "DELETE FROM requests WHERE id_requests = ?";
    $stmtDeleteRequest = $conexion->prepare($queryDeleteRequest);

    if (!$stmtDeleteRequest) {
        throw new Exception("Error al preparar la consulta de eliminación de la solicitud: " . $conexion->error);
    }

    $stmtDeleteRequest->bind_param("i", $requestId);
    $successRequest = $stmtDeleteRequest->execute();

    if (!$successRequest) {
        throw new Exception("Error al ejecutar la eliminación de la solicitud: " . $stmtDeleteRequest->error);
    }

    $requestsAffectedRows = $stmtDeleteRequest->affected_rows;
    $stmtDeleteRequest->close();

    // Si todo fue exitoso, confirmar la transacción
    $conexion->commit();

    // Devolver un mensaje de éxito con detalles
    echo json_encode([
        "success" => true,
        "message" => "Operación de eliminación completada.",
        "details" => [
            "contratos_eliminados" => $contractsAffectedRows,
            "solicitudes_eliminadas" => $requestsAffectedRows,
            "request_id_procesado" => $requestId,
            "student_id_asociado" => $studentId, // Devolver el ID del estudiante asociado
            "contract_ids_eliminados" => $contractIds // Devolver los IDs de contratos eliminados
        ]
    ]);

} catch (Exception $e) {
    // Si algo falla, revertir la transacción
    $conexion->rollback();
    echo json_encode(["error" => "Fallo en la eliminación: " . $e->getMessage()]);
} finally {
    // Asegurarse de cerrar la conexión a la base de datos
    if ($conexion) {
        $conexion->close();
    }
}
?>
