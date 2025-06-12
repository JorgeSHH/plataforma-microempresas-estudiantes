<?php
session_start();
session_unset();    // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión
header('Location: ../login/login.php?logout=true'); // Redirige al login con un mensaje de logout
exit();
