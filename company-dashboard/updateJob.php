<?php
require_once '../database/conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "No se pudo obtener el ID del usuario desde la sesión.";
    exit;
}

$jobId = $_POST['job-id'];
$jobTitle = $_POST['job-title'];
$jobCategory = $_POST['job-category'];
$jobType = $_POST['job-type'];
$jobSalary = $_POST['job-salary'];
$jobDuration = $_POST['job-duration'];
$jobLocation = $_POST['job-location'];
$jobRequirements = $_POST['job-requirements'];
$jobDescription = $_POST['job-description'];

$query = "UPDATE jobs SET job_title = ?, id_job_category = ?, type_job = ?, salary = ?, duration_job = ?, job_address = ?, job_requirements = ?, job_summary = ? WHERE id_job = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssssssssi", $jobTitle, $jobCategory, $jobType, $jobSalary, $jobDuration, $jobLocation, $jobRequirements, $jobDescription, $jobId);

if ($stmt->execute()) {
    echo "1"; // Éxito
} else {
    echo "0"; // Error
}