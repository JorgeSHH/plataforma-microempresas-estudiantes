<?php 
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Si no ha iniciado sesión, redirigir al login
    header('Location: login.php');
    exit();
}

// Opcional: Verificar el rol si la página es específica para un rol

if ($_SESSION['user_rol'] !== 'empresa') {
    // Redirigir a una página de acceso denegado o al dashboard principal
    header('Location: ../index.php'); // O dashboard_empresa.php si es empresa
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Desplegable</title>
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
                    <a href="#propuestas" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-suitcase-lg-fill" viewBox="0 0 16 16">
                            <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                        </svg>
                        <span class="menu-text">Propuestas realizadas</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#perfil" class="menu-link active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span class="menu-text">Perfil</span>
                    </a>
                </li>
                <li class="menu-item">
                <a href="'../index.php';" class="menu-link" ondblclick="window.location.href='../index.php';">
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
                    <img src="../assets/microempresa.png" alt="Logo de la empresa" id="company-logo-img">
                </div>
                <div class="company-basic-info">
                    <h1 class="company-name">Nombre de la Empresa</h1>
                    <p class="company-rif"><i class="fas fa-id-card"></i> <span id="rif">J-12345678-9</span></p>
                    <div class="contact-info">
                        <p class="company-email"><i class="fas fa-envelope"></i> <span id="email">empresa@ejemplo.com</span></p>
                        <p class="company-phone"><i class="fas fa-phone"></i> <span id="phone">+58 412 1234567</span></p>
                    </div>
                </div>
            </div>

            <!-- Información detallada -->
            <div class="company-details">
                <!-- Sección de dirección -->
                <section class="address-section">
                    <h2><i class="fas fa-map-marker-alt"></i> Dirección</h2>
                    <div class="address-details">
                        <p><strong>Estado:</strong> <span id="state">Miranda</span></p>
                        <p><strong>Parroquia:</strong> <span id="parish">Petare</span></p>
                        <p><strong>Sector:</strong> <span id="sector">Los Naranjos</span></p>
                        <p><strong>Calle:</strong> <span id="street">Av. Principal #123</span></p>
                    </div>
                </section>

                <!-- Sección de ofertas laborales -->
                <section class="jobs-section">
                    <h2><i class="fas fa-briefcase"></i> Ofertas Laborales</h2>
                    <div class="job-requirements">
                        <h3>Requisitos:</h3>
                        <p id="requirements">Estamos buscando profesionales con experiencia en desarrollo web, manejo de bases de datos y trabajo en equipo. Se valorará conocimiento en JavaScript, PHP y MySQL.</p>
                    </div>
                    <div class="contract-type">
                        <h3>Tipo de Contrato:</h3>
                        <p id="contract">Tiempo completo, beneficios según ley, oportunidades de crecimiento profesional.</p>
                    </div>
                </section>

                
            </div>

            <!-- Pie de página -->
           
        </div>
    </div>
        </main>
    </div>

    <script src="./scriptCProfile.js"></script>
</body>
</html>