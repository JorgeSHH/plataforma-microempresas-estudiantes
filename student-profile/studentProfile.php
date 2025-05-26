<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Profesional</title>
    <link rel="stylesheet" href="./styleSProfile.css">
   
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
                    <a href="#cerrar-sesion" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        <span class="menu-text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Contenido principal con el curriculum -->
        <main class="main-content" id="mainContent">
            <div class="cv-container">
                <header class="cv-header">
                    <div class="header-content">
                        <div class="profile-pic">
                            <img src="../assets/estudiante.png" alt="Foto de perfil">
                        </div>
                        <div class="header-text">
                            <h1>Jose González</h1>
                            <div class="contact-info">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg> maria.gonzalez@email.com</p>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                    </svg> +34 612 345 678</p>
                                
                            </div>
                        </div>
                    </div>
                </header>

                <div class="cv-content">
                    <div class="left-column">
                        <section class="cv-section about">
                            <h3><i class="fas fa-user"></i> Sobre mí</h3>
                            <p>Desarrolladora web con 5 años de experiencia en creación de interfaces de usuario atractivas y funcionales. Especializada en React y Vue.js, con pasión por el diseño responsive y la experiencia de usuario.</p>
                            
                        </section>
                        <section class="cv-section">
                            <h3><i class="fas fa-code"></i> datos personales</h3>
                            <ul class="responsibilities">
                                <p></i><b>direccion:</b> Madrid, España</p>
                                <p></i><b>sexo:</b>  femenino</p>
                                <p><b>cedula:</b>  30471428</p>
                                <p><b>edad:</b>  25</p>
                            </ul>
                        </section>

                        <section class="cv-section education">
                            <h3><i class="fas fa-graduation-cap"></i> Educación</h3>
                            <div class="cv-item">
                                <h4>Nivel más alto de educación alcanzado</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae, cumque?
                                </p>
                            </div>

                        </section>

                        <section class="cv-section">
                            <h3><i class="fas fa-code"></i> Habilidades</h3>
                            <ul class="responsibilities">
                                <li>feliz</li>
                                <li>puntual</li>
                                <li>feliz</li>
                                <li>puntual</li>
                                <li>feliz</li>
                                <li>puntual</li>
                            </ul>
                        </section>
                    </div>

                    <div class="right-column">
                        <section class="cv-section experience">
                            <h3><i class="fas fa-briefcase"></i> Experiencia Laboral</h3>
                            <ul class="responsibilities">
                            <li class="cv-item">
                                <h4>Desarrolladora Front-end Senior</h4>
                                <p class="company">TechSolutions S.A.</p>
                                <p class="date">2021 - Presente</p>
                            </li>
                            <li class="cv-item">
                                <h4>Desarrolladora Front-end</h4>
                                <p class="company">DigitalWeb S.L.</p>
                                <p class="date">2019 - 2021</p>
                            </li>
                            <li class="cv-item">
                                <h4>Desarrolladora Front-end</h4>
                                <p class="company">DigitalWeb S.L.</p>
                                <p class="date">2019 - 2021</p>
                            </li>
                            </ul>
                        </section>

                        <section class="cv-section projects">
                            <h3><i class="fas fa-project-diagram"></i> Cursos Relaizados</h3>
                            <ul class="responsibilities">
                                <li class="cv-item">
                                    <h4>nombre del curso</h4>
                                    <p>Intitucion pedro jimenes</p>
                                    <p>duracion de 5 meses</p>
                                </li>
                                <li class="cv-item">
                                    <h4>nombre del curso</h4>
                                    <p>Intitucion pedro jimenes</p>
                                    <p>duracion de 5 meses</p>
                                </li>
                            </ul>
                        </section>

                        <section class="cv-section languages">
                            <h3><i class="fas fa-language"></i> Portafolio y Curriculum</h3>
                            <ul>
                                <li><a href="#">Portafolio</a></li>
                                <li><a href="#">Curriculum</a></li>
                            </ul>
                        </section>
                    </div>
                </div>

                
            </div>
        </main>
    </div>
<!-- //footer -->
<footer>



    <script src="./scriptSProfile.js"></script>
</body>
</html>