<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styleRegistros.css">
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

<section class="formulario-empresa">
    <p id="ancla2">.</p>
    <article class="parte1">
        <div class="barra-progreso">
            Soy la barra de progreso
        </div>
        <h2 class="tituloDos">Creacion de la cuentas</h2>
        <div class="containerformulario">
            <form action="" method="post" id="frm">
                <div class="container-inputs">
                    <!-- <label class="imagen-empresa">
                        <svg xmlns="http://www.w3.org/2000/svg" color="white" width="100" height="100" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                          </svg>
                          agrege imagen de su empresa
                        <input type="file" name="imagen_empresa" id="imagen-empresa-input" style="display: none;">
                    </label> -->
                    <div class="datos-empresa">
                        <label for="correo" class="label-basico">
                            Correo electronico(empresa)
                            <input type="email" name="correo_empresa" id="correo_empresa"  class="input-basico">
                        </label>
                        <label for="nombre-empresa" class="label-basico">
                            Nombre de la empresa
                            <input type="text" name="nombre_empresa" id="nombre_empresa" class="input-basico">
                        </label>
                        <label for="contrasena" class="label-basico">
                            Contraseña
                            <input type="password" name="contrasena" id="contrasena" class="input-basico">
                        </label>
                        <label for="contrasena-vr" class="label-basico">
                            Confirmar contraseña
                            <input type="password" name="contrasena_vr" id="contrasena_vr" class="input-basico">
                        </label>
                    </div>

                   
                </div>  
                
        </div>
            <a href="/plataforma-microempresas-estudiantes/registros/registroEmpresas.php#ancla" class="btn-basico" id="btnSiguienteParte">Continuar</a>
        
       
    </article>
    <article class="parte2">
        <div class="barra-progreso">
            Soy la barra de progreso
        </div>
        <h2 class="tituloDos">Creacion de la cuentas</h2>
        <div class="containerFormulario2">
            <div class="caja-inputs">
                <h3>Datos de la empresa</h3>
                <label for="telf" class="label-basico">
                    Telefono de la empresa
                    <input type="text" name="telefono" id="telefono" class="input-basico">
                </label>
                <label for="rif" class="label-basico">
                    Rif
                    <input type="text" name="rif" id="rif" class="input-basico">
                </label>
                <label for="opciones">Tipo de contrato</label>
                <select id="opciones" name="opciones" class="input-select">
                    <option value="Presenciales">Presenciales</option>
                    <option value="Remotos">Remotos</option>
                    <option value="Ambos">Ambos (Remotos y prencenciales)</option>
                </select>
            </div>
            <div class="caja-inputs">
                <h3>Direccion fisica de la empresa</h3>
                <div class="dos-datos">
                    <label for="estado" class="label-basico" >
                        Estado
                        <input type="text" name="estado" id="estado" class="input-basico-dos">
                    </label>
                    <label for="parroquia" class="label-basico">
                        Parroquia
                        <input type="text" name="parroquia" id="parroquia" class="input-basico-dos">
                    </label>
                </div>
                <label for="sector" class="label-basico">
                    Sector
                    <input type="text" name="sector" id="sector" class="input-basico">
                </label>
                <label for="calle" class="label-basico">
                    Calle
                    <input type="text" name="calle" id="calle" class="input-basico">
                </label>
            </div>
            <div class="caja-inputs">
                <label for="requisitos" >
                    <h3>Requisitos para ofertas de trabajo</h3><br>   
                    <textarea name="requisitos" id="requisitos" cols="50" rows="18"></textarea>
                </label>
            </div>

        </div>
        <a href="/plataforma-microempresas-estudiantes/registros/registroEmpresas.php#ancla2" id="btnVolverParte" class="btn-basico">volver</a>
        <input type="submit"  value="Registrar Empresa" id="btnRegistrarEmpresa" value="Enviar">
</form>
    </article>

   

<p id="ancla">.</p>
</section>
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css " rel="stylesheet">
<script src="./registroEmpresa.js"></script>

</body>
</html>