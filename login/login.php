<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./syleLogin.css">
</head>
<body>
<header>
    <!-- inicio del header -->
    <nav class="menu">
    <div class="logo">
        <img src="../assets/logo2.png" alt="Logo" style="height: 80px;">
    </div>
    <ul class="menu-navegacion">
        <li><a href="../index.php">Inicio</a></li>
    
        <li><a href="../login/login.php">Login</a></li>
    </ul>
</nav>
</header>

<section class="login">
    <article class="container-login">
        <h2>Iniciar Sesion</h2>
        <form action="" class="container-inputs" id="formularioLogin" method="post">
            <input type="email" name="correo" id="correo" placeholder="Ingrese su Correo" class="input-basico">
            <input type="password" name="clave" id="clave" placeholder="Ingrese su Contraseña" class="input-basico">
            <div class="opciones">
                <a href="/plataforma-microempresas-estudiantes/registros/registro.php">Registrarse</a>
   
            </div>
            <input type="submit" value="Acceder" class="btn-basico" id="btn-login">
        </form>
    </article>
    
</section>
        <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js "></script>
        <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css " rel="stylesheet">
    <script src="./login.js"></script>
</body>
</html>