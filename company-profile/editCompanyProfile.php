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
    <title>Editar Perfil de la Compañía</title>
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
                    <a href="../company-dashboard/companyDashboard.php" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                        </svg>
                        <span class="menu-text">Inicio</span>
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
                    <a href="../database/logout.php" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
 

        <!-- Contenido principal -->
        <main class="main-content" id="mainContent">
            <div class="company-card-container">
                <div class="company-card-E">
                    <h1>Editar Perfil de la Compañía</h1>
                    <form method="POST" action="updateCompanyProfile.php" enctype="multipart/form-data">
                        <!-- Campo para cambiar la foto de perfil -->
                        <label for="img_perfil">Foto de Perfil:</label>
                        <input type="file" id="img_perfil" name="img_perfil" accept="image/*">

                        <label for="company_name">Nombre de la Empresa:</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>

                        <label for="company_rif">RIF:</label>
                        <input type="text" id="company_rif" name="company_rif" value="<?php echo htmlspecialchars($company['company_rif']); ?>" required>

                        <label for="company_email">Correo Electrónico:</label>
                        <input type="email" id="company_email" name="company_email" value="<?php echo htmlspecialchars($company['company_email']); ?>" required>

                        <label for="company_phone">Teléfono:</label>
                        <input type="text" id="company_phone" name="company_phone" value="<?php echo htmlspecialchars($company['company_phone']); ?>" required>

                        <label for="state">Estado:</label>
                        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($company['state']); ?>" required>

                        <label for="parish">Parroquia:</label>
                        <input type="text" id="parish" name="parish" value="<?php echo htmlspecialchars($company['parish']); ?>" required>

                        <label for="sector">Sector:</label>
                        <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($company['sector']); ?>" required>

                        <label for="street">Calle:</label>
                        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($company['street']); ?>" required>

                        <label for="job_requirements">Requisitos del Trabajo:</label>
                        <textarea id="job_requirements" name="job_requirements" required><?php echo htmlspecialchars($company['job_requirements']); ?></textarea>

                        <label for="job-type">Tipo de Contrato:</label>
                        <select id="job-type" name="job-type" required>
                            <option value="presencial" <?php echo ($company['contract_type'] === 'presencial') ? 'selected' : ''; ?>>Presencial</option>
                            <option value="remoto" <?php echo ($company['contract_type'] === 'remoto') ? 'selected' : ''; ?>>Remoto</option>
                        </select>

                        <button type="submit" class="submit-button">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="./scriptCProfile.js"></script>
</body>
</html>