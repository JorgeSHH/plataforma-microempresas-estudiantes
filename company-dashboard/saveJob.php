<?php
require_once '../database/conexion.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "No se pudo obtener el ID del usuario desde la sesión.";
    exit;
}

function getCurrentDate() {
    return date('Y-m-d H:i:s');
}
$publicationDate = getCurrentDate();

// Obtener el ID del usuario logueado
$idCompany = $_SESSION['user_id']; // ID del usuario logueado

// Obtener los datos del formulario
$jobTitle = $_POST['job-title'];
$jobDescription = $_POST['job-description'];
$jobLocation = $_POST['job-location'];
$jobType = $_POST['job-type'];
$jobCategory = $_POST['job-category'];
$jobSalary = $_POST['job-salary'];
$jobDuration = $_POST['job-duration'];
$timeLimit = $_POST['time-limit'];
$jobRequirements = $_POST['job-requirements'];

// Insertar el trabajo en la base de datos
$query = "INSERT INTO jobs (published_job_date, duration_job, job_title, job_address, job_requirements, time_limit, type_job, salary, job_summary, id_job_category, id_company) 
          VALUES ('$publicationDate', '$jobDuration', '$jobTitle', '$jobLocation', '$jobRequirements', '$timeLimit', '$jobType', '$jobSalary', '$jobDescription', '$jobCategory', '$idCompany')";

$resultCompany = $conexion->query($query);
if ($resultCompany) {
    echo "1"; // Éxito
} else {
    echo "0" . $conexion->error; // Error
}
?>