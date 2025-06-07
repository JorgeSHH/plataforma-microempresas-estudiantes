
//script de la captura, envio y recepcion de datos de loginGestion.php y login.php
const login = document.getElementById('formLogin');

login.addEventListener('submit', (e) => {
    e.preventDefault();
    console.log("se detiene");
    const datosForm = new FormData(login);

    const correo = datosForm.get('correo');
    const clave = datosForm.get('clave');
    

     // prueba si el javascript recive datos
     //console.log(datosForm.get('correo'));
     //console.log(datosForm.get('clave'));

    if (correo === "" && clave === "" ) {
        Swal.fire({
            title: "Ingrese los datos solicitados!",
            icon: "error",
            draggable: true
          });
    }else{


        fetch('./loginGestion.php', {
            method: 'POST',
            body: datosForm
        })
            .then(response => response.text())
            .then(data => {

            if (data === '1') {  
                const delayTime = 1500; 

                Swal.fire({
                    title: "Inicio de sesion Exitoso!",
                    icon: "success",
                    draggable: true
                  });

                setTimeout(() => {   
                    location.href = '../company-dashboard/companyDashboard.php';
                }, delayTime);

                
            }else if (data === '2') {
                const delayTime = 1500; 

                Swal.fire({
                    title: "Inicio de sesion Exitoso!",
                    icon: "success",
                    draggable: true
                  });

                setTimeout(() => {   
                    location.href = '../student-dashboard/studentDashboard.php';
                }, delayTime);

            } else if(data === '0') {
                Swal.fire({
                    title: "Correo o Contraseña invalida!",
                    icon: "error",
                    draggable: true
                  });
            }
        })
    }
    
})