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
        <!-- enctype="multipart/form-data"  -->
<form  id="registroEstudiante">
                <div class="container-inputs">
                    <label class="imagenEstudiante">
                        <svg xmlns="http://www.w3.org/2000/svg" color="white" width="100" height="100" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                          </svg>
                          agrege imagen para el perfil
                        <input type="file" name="imagenEstudiante" id="imagenEstudiante" style="display: none;">
                    </label>
                    <div class="datos-empresa">
                        <label for="correoEstudiante" class="label-basico">
                            Correo electronico
                            <input type="email" name="correoEstudiante" id="correoEstudiante" class="input-basico">
                        </label>
                        <label for="contrasena" class="label-basico">
                            Contraseña
                            <input type="password" name="contresena" id="contresena" class="input-basico">
                        </label>
                        <label for="contrasenaVr" class="label-basico">
                            Confirmar contraseña
                            <input type="password" name="contresenaVr" id="contresenaVr" class="input-basico">
                        </label>
                    </div>

                   
                </div>  
                
        </div>
          <a href="/plataforma-microempresas-estudiantes/registros/registroEstudiantes.php#ancla" class="btn-basico">Continuar</a>
        
       
    </article>
    <p id="ancla2-1">.</p>
    <article class="parte2">
        <div class="barra-progreso">
            Soy la barra de progreso
        </div>
        <h2 class="tituloDos"></h2>
        <div class="containerFormulario2">
            <div class="caja-inputs">
                <h3>Datos personales</h3>
                <label for="nombre" class="label-basico">
                    Nombre
                    <input type="text" name="nombre" id="nombre" class="input-basico">
                </label>
                <label for="apellido" class="label-basico">
                    Apellido
                    <input type="text" name="apellido" id="apellido" class="input-basico">
                </label>
                <label for="cedula" class="label-basico">
                    Cedula de identidad
                    <input type="text" name="cedula" id="cedula" class="input-basico">
                </label>
            </div>
            <div class="caja-inputs">
              <h3>  </h3>
                <label for="telefono" class="label-basico">
                    Telefono
                    <input type="text" name="telefono" id="telefono" class="input-basico">
                </label>
                <label for="fechaNacimiento" class="label-basico">
                    Fecha de nacimiento
                    <input type="date"  name="fechaNacimiento" id="fechaNacimiento" class="input-basico">
                </label>
                <label for="sexo" class="label-basico">
                        Sexo
                        <div class="dos-datos-radio">
                            <label for="masculino">
                                Masculino
                                <input type="radio" name="sexo" id="masculino" value="masculino" class="input-basico-dos">
                            </label>
                            <label for="femenino">
                                Femenino
                                <input type="radio" name="sexo" id="femenino" value="femenino" class="input-basico-dos">
                            </label>
                        </div>
                    </label>
            </div>
            
            <div class="caja-inputs">
            <h3>Direccion de la habitación</h3>
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

        </div>
        <div class="dos-datos-radio">
            <a href="/plataforma-microempresas-estudiantes/registros/registroEstudiantes.php#ancla2" class="btn-basico">volver</a>
            <a href="/plataforma-microempresas-estudiantes/registros/registroEstudiantes.php#ancla3" class="btn-basico">Continuar</a>
        </div>
      
       
    </article>
    <p id="ancla">.</p>
    
    <article class="parte3">
        <div class="caja-muestra">
            <div class="caja-con-scroll">
                <div class="contenido-form3">
                    <div class="barra-progreso">
                        Soy la barra de progreso
                    </div>
                    <h2 class="tituloDos">Creacion de la cuentas</h2>
                    <p class="textoAdition">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure nesciunt dolorem odio!
                    </p>
                    <div class="containerFormulario3">
                        <div class="caja-inputs">
                            <h3>Informacion personal</h3>
                            <br>
                            <label for="educacion" class="label-basico">
                                Nivel de educacion
                                <input type="text" name="educacion" id="educacion" class="input-basico">
                            </label>
                            <br>
                            <label for="resumen" class="label-basico">
                                Resumen profesional
                                 <textarea name="resumen" id="resumen" cols="5" rows="5"></textarea>
                            </label>
                        </div>
                        <hr>
                        <div class="caja-inputs">
                            <div class="caja-lateral">
                                <label for="portafolio" class="label-basico">
                                    Link de portafolio
                                    <input type="text" name="portafolio" id="portafolio" class="input-basico">
                                </label>
                                <label for="sintesis" class="label-basico">
                                    Link de sintesis curricular
                                    <input type="text"  name="sintesis" id="sintesis" class="input-basico">
                                </label>
                            </div>
                            <div class="boxAdition">
                                <div class="habilidadesTecnicas">
                                    <label for="habilidades" class="label-basico">
                                        Habilidades técnicas
                                        <textarea name="habilidades" id="habilidades" cols="5" rows="8"></textarea>
                                    </label>
                                </div>
                                <div class="preferenciaTrabajo">
                                    <label for="requisitos" class="label-basico">
                                         Preferencias de trabajo
                                        <p class="textoAdition">
                                        Haz click en el botom para seleccionar tus preferencias
                                        </p>
                                        <button type="button" class="btn-basico">elegir</button>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- registros individuales manejar lo del registro individual con atencion -->
                        <div class="caja-inputs">
                            <h4>Cursos realizados</h4>
                            <div class="caja-generadora">
                                <div class="marco-inputs">
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                </div>
                                        <div class="dos-datos-radio">
                                            <button type="button" class="btn-basico-tres">cancelar</button>
                                            <button type="button" class="btn-basico-dos">enviar</button>
                                         </div>
                            </div>
                            <br>
                            <div class="tabla-contenedor">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Telefono</th>
                                            <th>Telefono</th>
                                            <th>Telefono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>María González</td>
                                            <td>maria@ejemplo.com</td>
                                            <td >Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Carlos Pérez</td>
                                            <td>carlos@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Ana López</td>
                                            <td>ana@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Juan Martínez</td>
                                            <td>juan@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <div class="caja-inputs">
                            <h4>Cursos realizados</h4>
                            <div class="caja-generadora">
                                <div class="marco-inputs">
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                    <label for="sector" class="label-basico">
                                        Telefono
                                        <input type="text" name="sector" id="sector" class="input-basico">
                                    </label>
                                </div>
                                        <div class="dos-datos-radio">
                                            <button type="button" class="btn-basico-tres">cancelar</button>
                                            <button type="button" class="btn-basico-dos">enviar</button>
                                         </div>
                            </div>
                            <br>
                            <div class="tabla-contenedor">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Telefono</th>
                                            <th>Telefono</th>
                                            <th>Telefono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>María González</td>
                                            <td>maria@ejemplo.com</td>
                                            <td >Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Carlos Pérez</td>
                                            <td>carlos@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Ana López</td>
                                            <td>ana@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                        <tr>
                                            <td>Juan Martínez</td>
                                            <td>juan@ejemplo.com</td>
                                            <td>Editar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="dos-datos-radio">
            <a href="/plataforma-microempresas-estudiantes/registros/registroEstudiantes.php#ancla2-1" class="btn-basico">volver</a>
            <button class="btn-basico">Enviar</button>
        </div>
    </article>
    <p id="ancla3">.</p>
</form>

</section>


<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css " rel="stylesheet">
<script src="./registroEstudianteGestion.js"></script>
</body>
</html>