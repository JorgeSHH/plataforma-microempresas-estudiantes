const registroEstuddiante = document.getElementById('registroEstudiante');

registroEstuddiante.addEventListener('submit', (e) => { 
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const correo = document.getElementById('correoEstudiante').value;
    const contrasena = document.getElementById('contresena').value;
    const contrasenaVerificacion = document.getElementById('contresenaVr').value;
    const telefono = document.getElementById('telefono').value;
    const cedula = document.getElementById('cedula').value;
    const estado = document.getElementById('estado').value;
    const parroquia = document.getElementById('parroquia').value;
    const sector = document.getElementById('sector').value;
    const calle = document.getElementById('calle').value;
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const nivelEducacion = document.getElementById('educacion').value;
  


    // Comprobando que los datos lleguen
    if (contrasena !== contrasenaVerificacion) {
        Swal.fire({
            title: "Las contraseñas no coinciden...",
            icon: "error",
            draggable: true
        });
    }
    if (nombre == "" || apellido == "" || correo == "" || contrasena == "" || contrasenaVerificacion == "" || telefono == "" || cedula == "" || estado == "" || parroquia == "" || sector == "" || calle == "" || fechaNacimiento == "") {
        Swal.fire({
            title: "Campos vacíos...",
            text: "Por favor, rellene todos los campos",
            icon: "error",
            draggable: true
        });
    }

    const registroData = new FormData(registroEstuddiante);
    fetch('./registroEstudianteGestionBD.php', {
        method: 'POST',
        body: registroData
    })  
    .then(response => response.text())
    .then(data => {
        if (data === "0") {
            // Error, ver la consola para conocer el error
            console.log(data); 
        } else if(data === "12e") {
            Swal.fire({
                title: "Verifique Cédula o Correo",
                text: "La cédula o el correo ya se encuentran registrados en la plataforma",
                icon: "warning",
                draggable: true
            });
        } else if(data === "1") {
            Swal.fire({
                title: "Registro exitoso",
                text: "El estudiante ha sido registrado correctamente",
                icon: "success",
                draggable: true
            }).then(() => {
                window.location.href = "./index.html";
            });
        }
    })



})