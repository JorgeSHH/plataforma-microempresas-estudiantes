const registroForm = document.getElementById('registroEmpresa');

registroForm.addEventListener('submit', (e)=> {
    e.preventDefault();
    //comprobando que se detenga
    //console.log("se detiene");

    const correo = document.getElementById('correo-empresa').value;
    const nombreEmpresa = document.getElementById('nombre-empresa').value;
    const contrasena = document.getElementById('contresena').value;
    const contrasenaVerificacion = document.getElementById('contresena-vr').value;
    const telefono = document.getElementById('telf').value;
    const rif = document.getElementById('rif').value;
    const tipoContrato = document.getElementById('opciones').value;
    const estado = document.getElementById('estado').value;
    const parroquia = document.getElementById('parroquia').value;
    const sector = document.getElementById('sector').value;
    const calle = document.getElementById('calle').value;
    const requisitos = document.getElementById('requisitos').value;

    //comprobando que los datos lleguen
    //console.log(nombreEmpresa, correo, contrasena, contrasenaVerificacion, telefono, rif, tipoContrato, estado, parroquia, sector, calle, requisitos);
    
    if (contrasena !== contrasenaVerificacion) {
        Swal.fire({
            title: "La contraseñas no coinciden...",
            icon: "error",
            draggable: true
          });
    } 
    
    if (nombreEmpresa == "" || correo == "" || contrasena == "" || contrasenaVerificacion == "" || telefono == "" || rif == "" || tipoContrato == "" || estado == "" || parroquia == "" || sector == "" || calle == "" || requisitos == "") {
        Swal.fire({
            title: "campos vacios...",
            text: "Por favor rellene todos los campos",
            icon: "error",
            draggable: true
          });
    } 

    
    const registroData = new FormData(registroForm);

    fetch('./registroEmpresaGestionBD.php', {
         method: 'POST',
         body: registroData
     })
     .then(response => response.text())
     .then(data => {
          if (data === "12e") {
            Swal.fire({
                title: "Verifique Rif o el Correo",
                text: "El rif o el correo ya se encuentran registrados en la plataforma",
                icon: "warning",
                draggable: true
              });
          } else if(data === "0"){
            console.log(data);
            
          }else if(data === "1"){
            const delayTime = 1500; 

            Swal.fire({
                title: "Registro exitoso",
                icon: "success",
                draggable: true
              });
              setTimeout(() => {   
                location.href = '../login/login.php';
            }, delayTime);
          }
     })




})