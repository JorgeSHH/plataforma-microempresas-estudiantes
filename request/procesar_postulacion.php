<?php
// request/procesar_postulacion.php

// 1. Asegúrate de que no haya espacios en blanco ni caracteres antes de esta etiqueta PHP de apertura.
// Esto es crucial para que el JSON sea la primera salida.

require_once(__DIR__ . '/../database/conexion.php'); // Ajusta la ruta a tu archivo de conexión si es necesario

// Establecer el encabezado para indicar que la respuesta será JSON.
// Esto debe ser lo primero que se envíe al navegador.
header('Content-Type: application/json');

// Deshabilitar la visualización de errores PHP en la salida, para evitar que rompan el JSON.
// Es mejor loguearlos en un archivo de errores en producción.
ini_set('display_errors', 0);
error_reporting(E_ALL);

$response = ['status' => 'error', 'message' => ''];

// Verificar si la conexión a la base de datos es válida
if ($conexion->connect_error) {
    $response['message'] = 'Error de conexión a la base de datos: ' . $conexion->connect_error;
    echo json_encode($response);
    exit();
}

if (!isset($_POST['job_id']) || !isset($_POST['student_id'])) {
    $response['message'] = 'Faltan datos requeridos para la postulación.';
    echo json_encode($response);
    exit();
}

$job_id = (int)$_POST['job_id'];
$student_id = (int)$_POST['student_id'];

// 1. Obtener id_company a partir de id_job
$query_get_company_id = "SELECT id_company, job_title, duration_job FROM jobs WHERE id_job = ?"; // Añadimos duration_job aquí para una posible validación futura
$stmt_get_company_id = $conexion->prepare($query_get_company_id);
if (!$stmt_get_company_id) {
    $response['message'] = 'Error al preparar la consulta de compañía: ' . $conexion->error;
    echo json_encode($response);
    $conexion->close();
    exit();
}
$stmt_get_company_id->bind_param("i", $job_id);
$stmt_get_company_id->execute();
$stmt_get_company_id->bind_result($company_id, $job_title, $duration_job); // Capture duration_job
$stmt_get_company_id->fetch();
$stmt_get_company_id->close();

if (!$company_id) {
    $response['message'] = 'La oferta de trabajo especificada no existe o no tiene una compañía asociada.';
    echo json_encode($response);
    $conexion->close();
    exit();
}

// Opcional: Validar si la oferta está disponible antes de permitir la postulación
// Aunque el botón ya está deshabilitado en el frontend, esto es una buena medida de seguridad
if ($duration_job == 0) {
    $response['status'] = 'error';
    $response['message'] = 'Esta oferta de trabajo no está disponible para postulaciones en este momento.';
    echo json_encode($response);
    $conexion->close();
    exit();
}


// 2. Validación: Verificar si el estudiante ya está postulado a esta oferta
$query_check_postulacion = "SELECT id_requests FROM requests WHERE id_student = ? AND id_job = ?";
$stmt_check = $conexion->prepare($query_check_postulacion);

if (!$stmt_check) {
    $response['message'] = 'Error al preparar la verificación de postulación: ' . $conexion->error;
    echo json_encode($response);
    $conexion->close();
    exit();
}

$stmt_check->bind_param("ii", $student_id, $job_id);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // El estudiante ya está postulado
    $response['status'] = 'already_posted';
    $response['message'] = 'Ya te has postulado a esta oferta de trabajo.';
} else {
    // El estudiante NO está postulado, proceder con el registro
    $state = 'espera'; // Definir el estado inicial

    $query_insert_postulacion = "INSERT INTO requests (id_student, id_company, id_job, state) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($query_insert_postulacion);

    if (!$stmt_insert) {
        $response['message'] = 'Error al preparar la inserción de postulación: ' . $conexion->error;
        echo json_encode($response);
        $conexion->close();
        exit();
    }

    $stmt_insert->bind_param("iiis", $student_id, $company_id, $job_id, $state);

    if ($stmt_insert->execute()) {
        $response['status'] = 'success';
        $response['message'] = '¡Te has postulado exitosamente! Tu solicitud está en espera de revisión.';

        // Lógica opcional para enviar correo a la empresa (como se discutió previamente)
        // Obtener información del estudiante y la compañía para el correo
        $student_name = null; $student_email = null;
        $query_student_info = "SELECT studen_name, student_email FROM student WHERE id_student = ?";
        $stmt_student_info = $conexion->prepare($query_student_info);
        if ($stmt_student_info) { // Solo ejecutar si la preparación fue exitosa
            $stmt_student_info->bind_param("i", $student_id);
            $stmt_student_info->execute();
            $stmt_student_info->bind_result($student_name, $student_email);
            $stmt_student_info->fetch();
            $stmt_student_info->close();
        }

        $company_name = null; $company_email = null;
        $query_company_info = "SELECT company_name, company_email FROM company WHERE id_company = ?";
        $stmt_company_info = $conexion->prepare($query_company_info);
        if ($stmt_company_info) { // Solo ejecutar si la preparación fue exitosa
            $stmt_company_info->bind_param("i", $company_id);
            $stmt_company_info->execute();
            $stmt_company_info->bind_result($company_name, $company_email);
            $stmt_company_info->fetch();
            $stmt_company_info->close();
        }

        if ($company_email && $student_name && $job_title) {
            // Aquí iría tu código para enviar el email, por ejemplo con PHPMailer.
            // ... (Asegúrate de que este bloque de código no cause ningún 'echo' accidental)
            // Ejemplo de cómo NO debe haber un echo aquí:
            // echo "DEBUG: Enviando correo a " . $company_email; // ¡Esto causaría el error JSON!
        }

    } else {
        $response['message'] = 'Error desconocido al registrar tu postulación: ' . $stmt_insert->error;
    }
    $stmt_insert->close();
}

$stmt_check->close(); // Asegúrate de cerrar también el statement de verificación

$conexion->close(); // Cerrar la conexión a la base de datos

// Finalmente, envía la respuesta JSON
echo json_encode($response);
