<?php
require_once '../database/conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "No se pudo obtener el ID del usuario desde la sesión.";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$jobId = $data['id_job'];

$query = "DELETE FROM jobs WHERE id_job = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $jobId);

if ($stmt->execute()) {
    echo "1"; // Éxito
} else {
    echo "0"; // Error
}