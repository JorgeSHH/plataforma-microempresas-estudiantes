<?php
require_once '../database/conexion.php';

function getCurrentDate() {
    return date('Y-m-d H:i:s');
}
$publicationDate = getCurrentDate();

$jobTitle = $_POST['job-title'];
$jobDescription = $_POST['job-description'];
$jobLocation = $_POST['job-location'];
$jobType = $_POST['job-type'];
$jobCategory = $_POST['job-category'];
$jobSalary = $_POST['job-salary'];
$jobDuration = $_POST['job-duration'];
$timeLimit = $_POST['time-limit'];
$jobRequirements = $_POST['job-requirements'];


$query = "INSERT INTO jobs(published_job_date, duration_job, job_title, job_address, job_requirements, time_limit, type_job, salary, job_summary, id_job_category) VALUES ('$publicationDate', '$jobDuration', '$jobTitle', '$jobLocation', '$jobRequirements', '$timeLimit', '$jobType', '$jobSalary', '$jobDescription', '$jobCategory')";

// $query = "INSERT INTO `jobs`(published_job_date, duration_job, job_address, job_requirements, time_limit, type_job, salary, job_summary, id_job_category) 
// VALUES ('2025-02-12', '12 horas', 'Título de prueba', 'Dirección de prueba', 'Requisitos de prueba', '16 minutos', 'presencial', 18, 'Resumen de prueba', 1)";

// $query = "INSERT INTO jobs (published_job_date, duration_job, job_address, job_requirements, time_limit, type_job, salary,job_summary, id_job_category) VALUES ('$publicationDate', '$jobDuration', '$jobLocation', '$jobRequirements', '$timeLimit', '$jobType', '$jobSalary', '$jobDescription', '$jobCategory')";


$resultCompany = $conexion->query($query);
if ($resultCompany) {
    echo "1"; // Success
} else {
    echo "0" . $conexion->error;
}