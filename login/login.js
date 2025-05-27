const notificacion = document.getElementById("btn-login");

// notificacion.addEventListener("click", function() {
//     Swal.fire({
//         title: "Acceso concedido!",
//         icon: "success",
//         draggable: true,
//       });
// });

notificacion.addEventListener("click", function() {
    event.preventDefault(); // Evita el envío del formulario si es necesario
    Swal.fire({
        title: "Acceso concedido!",
         icon: "success",
        showConfirmButton: false, // Opcional, si quieres que no tenga botón
        timer: 3000 
      });
});