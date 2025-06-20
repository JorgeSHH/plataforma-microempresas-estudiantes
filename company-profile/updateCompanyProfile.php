<?php
require_once('../database/conexion.php');
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Obtener los datos enviados desde el formulario
$userId = $_SESSION['user_id'];
$companyName = $_POST['company_name'];
$companyRif = $_POST['company_rif'];
$companyEmail = $_POST['company_email'];
$companyPhone = $_POST['company_phone'];
$state = $_POST['state'];
$parish = $_POST['parish'];
$sector = $_POST['sector'];
$street = $_POST['street'];
$jobRequirements = $_POST['job_requirements'];
$contractType = $_POST['contract_type'];

// Procesar la imagen de perfil si se subió
if (isset($_FILES['img_perfil']) && $_FILES['img_perfil']['error'] === UPLOAD_ERR_OK) {
    $imgData = file_get_contents($_FILES['img_perfil']['tmp_name']);
    $queryImg = "UPDATE companies SET img_perfil = ? WHERE id_company = ?";
    $stmtImg = $conexion->prepare($queryImg);
    $stmtImg->bind_param("bi", $imgData, $userId);
    $stmtImg->send_long_data(0, $imgData);
    $stmtImg->execute();
}

// Actualizar los datos en la tabla companies
$queryCompany = "UPDATE companies SET company_name = ?, company_rif = ?, company_email = ?, company_phone = ?, job_requirements = ?, contract_type = ? WHERE id_company = ?";
$stmtCompany = $conexion->prepare($queryCompany);
$stmtCompany->bind_param("ssssssi", $companyName, $companyRif, $companyEmail, $companyPhone, $jobRequirements, $contractType, $userId);
$stmtCompany->execute();

// Actualizar los datos en la tabla company_address
$queryAddress = "UPDATE company_address SET state = ?, parish = ?, sector = ?, street = ? WHERE id_company = ?";
$stmtAddress = $conexion->prepare($queryAddress);
$stmtAddress->bind_param("ssssi", $state, $parish, $sector, $street, $userId);
$stmtAddress->execute();

header('Location: companyProfile.php?success=1');
?>