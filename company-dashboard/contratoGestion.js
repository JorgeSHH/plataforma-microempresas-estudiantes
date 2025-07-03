const aceptar = document.getElementById("aceptar");
const rechazar = document.getElementById("rechazar");
const verPerfil = document.getElementById("verPerfil");
const calificar = document.getElementById("calificar");

aceptar.addEventListener("click", function() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Acepta el contrato!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                '¡Aceptado!',
                'El contrato ha sido aceptado.',
                'success'
            );
        }
    });
});
rechazar.addEventListener("click", function() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Rechaza el contrato!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, rechazar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                '¡Rechazado!',
                'El contrato ha sido rechazado.',
                'error'
            );
        }
    });
});

verPerfil.addEventListener("click", function() {
    fetch('../gestion-solicitud-empresa/verPerfil.php')
        .then(response => response.json())
        .then(data => {
            
          
        })
        .catch(error => {
            console.error('Error fetching profile:', error);
            Swal.fire({
                title: 'Error',
                text: 'No se pudo cargar el perfil.',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        });
});
calificar.addEventListener("click", function() {
    location.href = "calificacion.html";
});

