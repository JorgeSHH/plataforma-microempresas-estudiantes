<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral Desplegable</title>
    <link rel="stylesheet" href="./styleCDashboard.css">
</head>
<body>
<div class="container-menu">
              <!-- Menú lateral -->
              <nav class="sidebar" id="sidebar">
            <div class="menu-toggle" id="menuToggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </div>
            
            <div class="logo">
                <img src="../assets/logo.png" alt="Logo">
            </div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="../index.php" class="menu-link" ondblclick="window.location.href='../index.php';">
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
            <div class="profile-header">
            <div class="profile-info">
            <img class="profile-pic">
            <div class="user-details">
            <!-- aca metemos el nombre del usuario -->
                <div class="user-name">Armando</div> 
                     <!-- aca metemos el Apellido del usuario -->
                <div class="user-handle">Martinez</div>
            </div>
            </div>
            </div>
            <section class="welcome">
                <h1>Bienvenido, Haz crecer tu Microempresa</h1>
                <p>Crea ofertas de trabajo.</p>
            </section>
                
            <div id="contentSection">
                <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta de Empleo</title>


    <div class="job-card">
        <div class="job-header">
            <h1 class="job-title">Desarrollador Frontend Senior</h1>
            <p class="job-company">Tech Solutions Inc.</p>
            
            <div class="job-meta">
                <span class="job-meta-item">
                    <i>📅</i> Publicado: 15/05/2023
                </span>
                <span class="job-meta-item">
                    <i>⏳</i> Tiempo limite: 12 meses
                </span>
                <span class="job-meta-item">
                    <i>📍</i> Remoto
                </span>
                <span class="job-meta-item">
                    <i>💰</i> <span class="job-salary">$3,500/mes</span>
                </span>
            </div>
        </div>
        
            <!-- Nueva sección para la categoría -->
    <div class="job-category">
        <span class="category-label">Categoría:</span>
        <span class="category-value">Tecnología e innovación</span>
    </div>

        <div class="job-section">
            <h3 class="job-section-title">Resumen del puesto</h3>
            <p class="job-section-content">
                Buscamos un desarrollador Frontend Senior con experiencia en React.js para unirse a nuestro equipo de desarrollo de productos digitales. Trabajarás en proyectos innovadores para clientes internacionales.
            </p>
        </div>
        
        <div class="job-section">
            <h3 class="job-section-title">Requisitos</h3>
            <p class="job-section-content">
                • 5+ años de experiencia en desarrollo Frontend<br>
                • Dominio de React.js y Redux<br>
                • Experiencia con APIs REST<br>
                • Conocimientos de TypeScript<br>
                • Inglés intermedio-avanzado<br>
                • Capacidad para trabajar en equipo
            </p>
        </div>
        
        <div class="job-section">
            <h3 class="job-section-title">Ubicación</h3>
            <p class="job-section-content">
                Av. Innovación 1234, Piso 5, Ciudad Tecnológica
            </p>
        </div>
        
        <div class="job-footer">
            <span>ID de oferta: #JOB-12345</span>
            <span>Válida hasta: 30/06/2023</span>
            <button class="apply-button">Postularse</button>
        </div>
    </div>

            </div>

   
        </main>
                  <!-- Contenido Principal -->

          <!-- Columna Derecha -->
          <div class="sidebar-right">
    <!-- Barra de búsqueda -->
    

   

    <!-- Sección de Contratos con scroll -->
    <div class="contracts-section">
        
        <div class="filter-buttons-container" style="max-height: 240px; overflow-y: auto;">
        <h3>Contratos</h3>
        <div class="contracts-container">
            <!-- Elemento repetido de contrato -->
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre de la empresa</div>
                    <div class="job-title">Título del empleo</div>
                </div>
                <button class="view-button">Verr</button>
            </div>
            
            <!-- Repetir elementos para demostrar el scroll -->
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre de la empresa</div>
                    <div class="job-title">Título del empleo</div>
                </div>
                <button class="view-button">Verr</button>
            </div>
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre de la empresa</div>
                    <div class="job-title">Título del empleo</div>
                </div>
                <button class="view-button">Verr</button>
            </div>
            <div class="contract-item">
                <div>
                    <div class="company-name">Nombre de la empresa</div>
                    <div class="job-title">Título del empleo</div>
                </div>
                <button class="view-button">Verr</button>
            </div>
            
            </div>
        </div>
         <!-- Más elementos... (repetir estructura según necesidad) -->
    </div>
</div>
         <!-- Columna Derecha -->
       
    </div>

    <!-- Botón para abrir la ventana modal -->
<div class="add-button-container">
    <button class="add-button" id="openModalButton">+</button>
</div>

<!-- Ventana modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <span class="close-button" id="closeModalButton">&times;</span>
        <h2>Agregar Nueva Oferta</h2>
        <form id="jobForm">
            <label for="job-title">Título del empleo:</label>
            <input type="text" id="job-title" name="job-title" placeholder="Ejemplo: Desarrollador Frontend Senior" required>
            
            <label for="job-company">Nombre de la empresa:</label>
            <input type="text" id="job-company" name="job-company" placeholder="Ejemplo: Tech Solutions Inc." required>
            
            <label for="job-category">Categoría:</label>
            <select id="job-category" name="job-category" required>
                <option value="tecnologia">Tecnología e innovación</option>
                <option value="marketing">Marketing y publicidad</option>
                <option value="recursos-humanos">Recursos humanos</option>
                <option value="educacion">Educación y formación</option>
                <option value="salud">Salud y bienestar</option>
                <option value="logistica">Logística y transporte</option>
            </select>
            
            <label for="job-type">Tipo de trabajo:</label>
            <select id="job-type" name="job-type" required>
                <option value="presencial">Presencial</option>
                <option value="remoto">Remoto</option>
                <option value="hibrido">Híbrido</option>
            </select>
            
            <label for="job-salary">Salario:</label>
            <input type="text" id="job-salary" name="job-salary" placeholder="Ejemplo: $3,500/mes" required>
            
            <label for="job-duration">Tiempo limite:</label>
            <input type="text" id="job-duration" name="job-duration" placeholder="Ejemplo: 12 meses" required>
            
            <label for="job-location">Ubicación:</label>
            <input type="text" id="job-location" name="job-location" placeholder="Ejemplo: Remoto" required>
            
            <label for="job-requirements">Requisitos:</label>
            <textarea id="job-requirements" name="job-requirements" placeholder="Ejemplo: 5+ años de experiencia, React.js, APIs REST..." required></textarea>
            
            <label for="job-description">Descripción:</label>
            <textarea id="job-description" name="job-description" placeholder="Escribe una breve descripción del empleo..." required></textarea>
            
            <button type="submit" class="submit-button">Guardar</button>
        </form>
    </div>
</div>

    <script src="./scriptCDashboard.js"></script>
</body>
</html>