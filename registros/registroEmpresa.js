
     const parte1 = document.querySelector('.parte1');
     const parte2 = document.querySelector('.parte2');
     const btnSiguiente = document.getElementById('btnSiguienteParte');
     const btnVolver = document.getElementById('btnVolverParte');
     const btnEnvio = document.getElementById('btnRegistrarEmpresa');


  

     // Navegación entre partes del formulario
     btnSiguiente.addEventListener('click', () => {

         // Validar campos de la parte 1 antes de avanzar
         const correo = document.getElementById('correo_empresa').value.trim();
         const nombreEmpresa = document.getElementById('nombre_empresa').value.trim();
         const contrasena = document.getElementById('contrasena').value.trim();
         const contrasenaVr = document.getElementById('contrasena_vr').value.trim();

         if (!correo || !nombreEmpresa || !contrasena || !contrasenaVr) {   
             Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 text: "Por favor, completa todos los campos de la Parte 1.",
               });
             return;
         }

         if (contrasena !== contrasenaVr) {
             Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 text: "Las contraseñas no coinciden.",
               });
             return;
         }

         // Validación de formato de correo (básica)
         const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
         if (!emailRegex.test(correo)) {
             Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 text: "Por favor, ingresa un correo electrónico válido.",
               });
             return;
         }

         // Validación de longitud de contraseña (ejemplo)
         if (contrasena.length < 4) {
             Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 text: "La contraseña debe tener al menos 4 caracteres.",
               });
             return;
         }

     
     });
    
    btnEnvio.addEventListener('click', () => {
        console.log("Enviando datos del formulario");
        event.preventDefault();
    const telefono = document.getElementById('telefono').value.trim();
    const rif = document.getElementById('rif').value.trim();
    const estado = document.getElementById('estado').value.trim();
    const parroquia = document.getElementById('parroquia').value.trim();
    const sector = document.getElementById('sector').value.trim();
    const calle = document.getElementById('calle').value.trim();

    if (!telefono || !rif || !estado || !parroquia || !sector || !calle) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, completa todos los campos de la Parte 2.",
          });
        return;    
        }
        
    
     fetch("registro_empresa.php", {
         method: "POST",
         body: new FormData(frm)
     }).then(response => response.text()).then(response => {
         if (response == "rif") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El RIF ya está registrado.",
                timer: 1500
              });
         } else if (response == "correo") {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El correo ya está registrado.",
                timer: 1500
              });
         } else if (response == "ok" ) {
            
              Swal.fire({
                title: "Registro exitiso!",
                icon: "success",
                showConfirmButton: false,
                timer: 1500
              });
         }
     })
    });