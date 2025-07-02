<?php
// request/procesar_postulacion.php

require_once('../database/conexion.php'); // Ajusta la ruta a tu archivo de conexión

header('Content-Type: application/json'); // Indicar que la respuesta será JSON

$response = ['status' => 'error', 'message' => ''];

// Iniciar sesión si es necesario para obtener el user_id de la sesión (aunque ya lo enviamos por POST)
// session_start(); 
// if (!isset($_SESSION['user_id'])) {
//     $response['message'] = 'Usuario no autenticado.';
//     echo json_encode($response);
//     exit();
// }
// $student_id = $_SESSION['user_id']; // Si quieres obtenerlo siempre de la sesión por seguridad


// Verificar si los datos necesarios fueron enviados por POST
if (!isset($_POST['job_id']) || !isset($_POST['student_id'])) {
    $response['message'] = 'Faltan datos requeridos para la postulación.';
    echo json_encode($response);
    exit();
}

$job_id = (int)$_POST['job_id']; // Castear a int por seguridad
$student_id = (int)$_POST['student_id']; // Castear a int por seguridad

// 1. Obtener id_company a partir de id_job
$query_get_company_id = "SELECT id_company, job_title FROM jobs WHERE id_job = ?";
$stmt_get_company_id = $conexion->prepare($query_get_company_id);
if (!$stmt_get_company_id) {
    $response['message'] = 'Error al preparar la consulta de compañía: ' . $conexion->error;
    echo json_encode($response);
    exit();
}
$stmt_get_company_id->bind_param("i", $job_id);
$stmt_get_company_id->execute();
$stmt_get_company_id->bind_result($company_id, $job_title);
$stmt_get_company_id->fetch();
$stmt_get_company_id->close();

if (!$company_id) {
    $response['message'] = 'La oferta de trabajo especificada no existe o no tiene una compañía asociada.';
    echo json_encode($response);
    exit();
}

// 2. Validación: Verificar si el estudiante ya está postulado a esta oferta
$query_check_postulacion = "SELECT id_requests FROM requests WHERE id_student = ? AND id_job = ?";
$stmt_check = $conexion->prepare($query_check_postulacion);

if (!$stmt_check) {
    $response['message'] = 'Error al preparar la verificación de postulación: ' . $conexion->error;
    echo json_encode($response);
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
        exit();
    }

    $stmt_insert->bind_param("iiis", $student_id, $company_id, $job_id, $state);

    if ($stmt_insert->execute()) {
        $response['status'] = 'success';
        $response['message'] = '¡Te has postulado exitosamente! Tu solicitud está en espera de revisión.';

        // Opcional: Enviar correo a la empresa
        // Aquí necesitarás los detalles de la empresa (correo) y del estudiante (nombre, correo)
        // para personalizar el correo.
        // Consulta los datos del estudiante:
        $query_student_info = "SELECT studen_name, student_email FROM student WHERE id_student = ?";
        $stmt_student_info = $conexion->prepare($query_student_info);
        $stmt_student_info->bind_param("i", $student_id);
        $stmt_student_info->execute();
        $stmt_student_info->bind_result($student_name, $student_email);
        $stmt_student_info->fetch();
        $stmt_student_info->close();

        // Consulta los datos de la empresa:
        $query_company_info = "SELECT company_name, company_email FROM company WHERE id_company = ?";
        $stmt_company_info = $conexion->prepare($query_company_info);
        $stmt_company_info->bind_param("i", $company_id);
        $stmt_company_info->execute();
        $stmt_company_info->bind_result($company_name, $company_email);
        $stmt_company_info->fetch();
        $stmt_company_info->close();

        if ($company_email && $student_name && $job_title) {
            // Lógica para enviar el correo. Necesitas tu librería/función de envío de correo aquí.
            // Por ejemplo, si usas PHPMailer:
            // require_once '../../path/to/PHPMailer/src/PHPMailer.php';
            // require_once '../../path/to/PHPMailer/src/SMTP.php';
            // require_once '../../path/to/PHPMailer/src/Exception.php';

            // use PHPMailer\PHPMailer\PHPMailer;
            // use PHPMailer\PHPMailer\Exception;

            // $mail = new PHPMailer(true);
            // try {
            //     // Configuración del servidor SMTP
            //     $mail->isSMTP();
            //     $mail->Host       = 'smtp.yourdomain.com'; // Servidor SMTP
            //     $mail->SMTPAuth   = true;
            //     $mail->Username   = 'your_email@yourdomain.com'; // Tu correo
            //     $mail->Password   = 'your_email_password'; // Tu contraseña
            //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O PHPMailer::ENCRYPTION_SMTPS para 465
            //     $mail->Port       = 587; // Puerto SMTP

            //     // Remitentes y destinatarios
            //     $mail->setFrom('no-reply@yourdomain.com', 'Sistema de Postulaciones'); // Tu correo
            //     $mail->addAddress($company_email, $company_name); // Correo de la empresa

            //     // Contenido del correo
            //     $mail->isHTML(true);
            //     $mail->Subject = 'Nueva Postulacion a tu Oferta: ' . htmlspecialchars($job_title);
            //     $mail->Body    = "Hola " . htmlspecialchars($company_name) . ",<br><br>"
            //                    . "El estudiante <b>" . htmlspecialchars($student_name) . "</b> (" . htmlspecialchars($student_email) . ") se ha postulado a tu oferta de empleo: <b>" . htmlspecialchars($job_title) . "</b>.<br><br>"
            //                    . "Puedes gestionar esta postulación desde tu panel de control.<br><br>"
            //                    . "Saludos,<br>Tu Equipo de la Plataforma";
            //     $mail->AltBody = "Hola " . htmlspecialchars($company_name) . ",\n\n"
            //                    . "El estudiante " . htmlspecialchars($student_name) . " (" . htmlspecialchars($student_email) . ") se ha postulado a tu oferta de empleo: " . htmlspecialchars($job_title) . ".\n\n"
            //                    . "Puedes gestionar esta postulación desde tu panel de control.\n\n"
            //                    . "Saludos,\nTu Equipo de la Plataforma";

            //     $mail->send();
            //     // $response['message'] .= " Se ha enviado una notificación por correo a la empresa."; // Opcional
            // } catch (Exception $e) {
            //     // Puedes loguear el error de correo, pero no lo muestres al usuario final si no es crítico.
            //     // error_log("Error al enviar correo a la empresa: {$mail->ErrorInfo}");
            // }
        }

    } else {
        $response['message'] = 'Error desconocido al registrar tu postulación: ' . $stmt_insert->error;
    }
    $stmt_insert->close();
}

$conexion->close();

echo json_encode($response);
?>