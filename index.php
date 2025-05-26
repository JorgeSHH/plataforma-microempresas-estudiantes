<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./home/styleHome.css">
</head>
<body>
<header>
    <!-- inicio del header -->
    <nav class="menu">
    <div class="logo">
        <img src="./assets/logo2.png" alt="Logo" style="height: 80px;">
    </div>
    <ul class="menu-navegacion">
        <li><a href="./index.php">Inicio</a></li>
    
        <li><a href="./login/login.php">Login</a></li>
    </ul>
</nav>
</header>
<!-- fin del header -->

<!-- Inicio del hero del home -->
<section id="hero">
        <div class="container">
            <h1 id="cita">"Haz que tu dinero trabaje para ti, no al revés. La libertad financiera no se trata de cuánto ganas, sino de cómo administras lo que tienes."</h1>
            <p id="simon">Es hora de trabajar</p>
            <span class="text">
                <p>¡Bienvenido a A&J! Nuestro objetivo es impulsar el crecimiento mutuo, creando oportunidades de aprendizaje reales para los estudiantes mientras ayudamos a los negocios a encontrar el talento que necesitan!</p>
            </span>
            <form>
                <!-- este boton hace que se desplace hacia la mitad inferior de la pagina, donde hay informacion breve de los usuarios y un acceso directo, junto con el footer al final -->
                <button class="controls" type="button" onclick="document.getElementById('container-box').scrollIntoView({ behavior: 'smooth' });">Saber más</button>
            </form>
        </div>
    </section>
<!-- section secundaria del home -->
    <section id="container-box">
                <div class="box">
                    <article class="content-img">
                        <img class="imagen-1" >
                    </article>
                    <div class="text">
                        <h3>Estudiantes</h3>
                        <p>¡Conecta talento con oportunidades! En nuestra plataforma, estudiantes apasionados encuentran el espacio ideal para desarrollar sus habilidades y ingresos mientras continuas tus estudios.</p>
                        <form>
                        <button class="controls" type="button" onclick="document.querySelector('.section-header').scrollIntoView({ behavior: 'smooth' });">¿Comó funciona?</button>
            </form>
                    </div>
                </div>
                <div class="box">
                    
                    <div class="text">
                        <h3>Microempresas</h3>
                        <p>Las microempresas son el motor de la innovación, y nosotros las ayudamos a encontrar la ayuda perfecto para impulsar su éxito. </p>
                        <form>
                <button class="controls" type="button" onclick="document.querySelector('.section-header').scrollIntoView({ behavior: 'smooth' });">¿Comó funciona?</button>
            </form>
                    </div>
                    <article class="content-img">
                        <img class="imagen-2" >
                    </article>
                </div>
    </section>

<!-- section secundaria del home -->
<section class="container">
        <section class="section-header">
            <h2>Instrucciones de la Plataforma</h2>
            <p>Guías para ayudarte a tener éxito en nuestra plataforma de emparejamiento laboral, ya seas estudiante o microempresa.</p>
        </section>
        <!-- Tabs -->
        <div class="tabs">
            <button id="tab-estudiantes" class="tab tab-active">Para Estudiantes</button>
            <button id="tab-empresas" class="tab">Para Microempresas</button>
        </div>
        <!-- Contenido para Estudiantes -->
        <div id="content-estudiantes" class="tab-content">
            <div class="grid">
                <!-- Tarjeta 1 -->
                <div class="card">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3>Crea y registra un Usuiario para iniciar sesion</h3>
                    <p>Ingresa tus datos y crea un perfil para destacar tus habilidades y experiencia para captar la atención de los empleadores.</p>
                </div>
                <!-- Tarjeta 2 -->
                <div class="card">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3>Explora tus oportunidades</h3>
                    <p>Navega por las ofertas disponibles y utiliza nuestros filtros de categorias para encontrar las más adecuadas para ti.</p>
                </div>
                <!-- Tarjeta 3 -->
                <div class="card">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3>Gestiona tus postulaciones</h3>
                    <p>Una vez encuentres un trabajo al cual postularte puedes seleccionar la opción de "solicitar trabajo" y espera ser aceptado o rechazado para el trabajo. Buena suerte.</p>
                </div>
            </div>
        </div>
        <!-- Contenido para Microempresas -->
        <div id="content-empresas" class="tab-content hidden">
            <div class="grid">
                <!-- Tarjeta 2 -->
                <div class="card">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3>Registra tu Empresa o Microempresa</h3>
                    <p>Completa el perfil de tu empresa con información relevante sobre tu negocio.</p>
                </div>
                            <!-- Tarjeta 1 -->
                            <div class="card">
                                <div class="icon-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3>Atrae Talento Joven. Crea ofertas laborales</h3>
                                <p>Publica tus tranajos en la plataforma especificando requisitos, responsabilidades y beneficios.
                                </p>
                            </div>
                <!-- Tarjeta 3 -->
                <div class="card">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <h3>Revisa las solicitudes de los postulantes</h3>
                    <p>evalua las solitudes y perfiles de los estudiantes que coinciden con tus necesidades laborales y establece tus contratos.</p>
                </div>
            </div>
            </div>
        </section>
<!-- //footer -->
    <footer>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Condiciones y politica</a></li>
                    <li><a href="#">Contactos</a></li>
                </ul>
                <p>&copy; <span class="color-acento2">Armando Martinez</span> 2025, All Rights <span class="color-acento2">Reserved</span></p>
            </nav>
        </div>
    </footer>





    <script src="./home/app.js"></script>   
</body>
</html>