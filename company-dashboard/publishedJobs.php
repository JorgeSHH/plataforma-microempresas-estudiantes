<?php
require_once '../database/conexion.php';

// Consultar los trabajos publicados por el usuario
// Asegúrate de tener el ID del usuario (por ejemplo, almacenado en la sesión)
session_start();
$userId = $_SESSION['user_id']; // Cambia esto según cómo manejes la sesión del usuario

$query = "SELECT * FROM jobs WHERE id_company = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajos Publicados</title>
    <link rel="stylesheet" href="./stylePublishedJobs.css">
</head>
<body>
    <div class="container">
        <h1>Trabajos Publicados</h1>
        <button id="openModalButton" class="open-modal-button">Ver Trabajos Publicados</button>

        <!-- Ventana modal -->
        <div class="modal" id="modal">
            <div class="modal-content">
                <span class="close-button" id="closeModalButton">&times;</span>
                <h2>Tus Trabajos Publicados</h2>
                <div class="jobs-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="job-card">
                            <h3 class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></h3>
                            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($row['job_address']); ?></p>
                            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($row['type_job']); ?></p>
                            <p><strong>Salario:</strong> <?php echo htmlspecialchars($row['salary']); ?></p>
                            <p><strong>Duración:</strong> <?php echo htmlspecialchars($row['duration_job']); ?></p>
                            <p><strong>Fecha límite:</strong> <?php echo htmlspecialchars($row['time_limit']); ?></p>
                            <p><strong>Requisitos:</strong> <?php echo htmlspecialchars($row['job_requirements']); ?></p>
                            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($row['job_summary']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="./scriptPublishedJobs.js"></script>
</body>
</html>