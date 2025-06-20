<?php 
session_start();
require_once('../database/conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Verificar el rol del usuario
if ($_SESSION['user_rol'] !== 'empresa') {
    header('Location: ../index.php');
    exit();
}

// Obtener los datos actuales de la compañía desde la base de datos
$userId = $_SESSION['user_id'];

// Obtener datos de la tabla companies
$queryCompany = "SELECT * FROM companies WHERE id_company = ?";
$stmtCompany = $conexion->prepare($queryCompany);
$stmtCompany->bind_param("i", $userId);
$stmtCompany->execute();
$resultCompany = $stmtCompany->get_result();
$company = $resultCompany->fetch_assoc();

// Obtener datos de la tabla company_address
$queryAddress = "SELECT * FROM company_address WHERE id_company = ?";
$stmtAddress = $conexion->prepare($queryAddress);
$stmtAddress->bind_param("i", $userId);
$stmtAddress->execute();
$resultAddress = $stmtAddress->get_result();
$address = $resultAddress->fetch_assoc();

// Combinar datos de ambas tablas
$company = array_merge($company, $address);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Compañía</title>
    <link rel="stylesheet" href="./styleCProfile.css">
</head>
<body>
    <div class="container">
          <!-- Menú lateral -->
          <nav class="sidebar" id="sidebar">
            <div class="menu-toggle" id="menuToggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </div>
            
            <div class="logo">
                <img src="../assets/logo2.png" alt="Logo">
            </div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="../index.php" class="menu-link" ondblclick="window.location.href='../company-dashboard/companyDashboard.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                        </svg>    
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>
                <li class="menu-item">
                <a href="'./publishedJobs.php';" class="menu-link" ondblclick="window.location.href='../company-dashboard/publishedJobs.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                            <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                        </svg>
                        <span class="menu-text">Trabajos Publicados</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div class="menu-link" ondblclick="window.location.href='../company-profile/companyProfile.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span class="menu-text">Perfil</span>
                    </div>
                </li>
                <li class="menu-item">
                <a href="../database/logout.php" class="menu-link" ondblclick="window.location.href='../database/logout.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
            
        </nav>
        <!-- Contenido principal -->
        <main class="main-content" id="mainContent">
            <div class="company-card-container">
                <div class="company-card">
                    <!-- Encabezado con logo y datos básicos -->
                    <div class="company-header">
                        <div class="company-logo">
                            <?php
                            if (!empty($company['img_perfil'])) {
                                $imgData = base64_encode($company['img_perfil']);
                                echo '<img src="data:image/jpeg;base64,' . $imgData . '" alt="Logo de la empresa" id="company-logo-img">';
                            } else {
                                echo '<img src="../assets/default-logo.png" alt="Logo por defecto" id="company-logo-img">';
                            }
                            ?>
                        </div>
                        <div class="company-basic-info">
                            <h1 class="company-name"><?php echo htmlspecialchars($company['company_name']); ?></h1>
                            <p class="company-rif"><strong>RIF:</strong> <?php echo htmlspecialchars($company['company_rif']); ?></p>
                            <div class="contact-info">
                                <p class="company-email"><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($company['company_email']); ?></p>
                                <p class="company-phone"><strong>Teléfono:</strong> <?php echo htmlspecialchars($company['company_phone']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Información detallada -->
                    <div class="company-details">
                        <section class="address-section">
                            <h2>Dirección</h2>
                            <div class="address-details">
                                <p><strong>Estado:</strong> <?php echo htmlspecialchars($company['state']); ?></p>
                                <p><strong>Parroquia:</strong> <?php echo htmlspecialchars($company['parish']); ?></p>
                                <p><strong>Sector:</strong> <?php echo htmlspecialchars($company['sector']); ?></p>
                                <p><strong>Calle:</strong> <?php echo htmlspecialchars($company['street']); ?></p>
                            </div>
                        </section>
                        <section class="additional-info">
                            <h2>Información Adicional</h2>
                            <p><strong>Requisitos del Trabajo:</strong> <?php echo htmlspecialchars($company['job_requirements']); ?></p>
                            <p><strong>Tipo de Contrato:</strong> <?php echo htmlspecialchars($company['contract_type']); ?></p>
                        </section>

                        <!-- Botón para editar el perfil -->
                        <div class="edit-profile-button-container">
                            <a href="editCompanyProfile.php" class="edit-profile-button">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>



    
    <script src="./scriptCProfile.js"></script>
</body>
</html>