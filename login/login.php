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
    <nav class="menu">
        <div class="logo">
            <h2>logo</h2>
        </div>
        <ul class="menu-navegacion">
            <li><a href="/index.php">Home</a></li>
            <li><a href="#">Empresas</a></li>
            <li><a href="#">Estudiantes</a></li>
            <li><a href="./login/login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="login">
    <article class="container-login">
        <h2>Iniciar Sesion</h2>
        <form action="" class="container-inputs">
            <input type="email" name="correo" id="correo" placeholder="Ingrese su Correo" class="input-basico">
            <input type="password" name="clave" id="clave" placeholder="Ingrese su Contraseña" class="input-basico">
            <div class="opciones">
                <a href="/plataforma-estudiantes-microempresas/registros/registro.php">Registrarse</a>
                <a href="#">Recuperar contraseña</a>
            </div>
            <input type="submit" value="Acceder" class="btn-basico">
        </form>
    </article>
</section>

    
</body>
</html>