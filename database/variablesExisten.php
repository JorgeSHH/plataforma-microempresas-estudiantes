<?php
// ¡Importante! Siempre inicia la sesión al principio de tu archivo
// donde necesites acceder o modificar variables de sesión.
session_start();

// Ahora puedes usar echo para mostrar el valor de las variables de sesión
if (isset($_SESSION['logged_in'])) {
    echo "Usuario logueado: " . ($_SESSION['logged_in'] ? 'Sí' : 'No') . "<br>";
} else {
    echo "Variable 'logged_in' no establecida.<br>";
}

if (isset($_SESSION['user_id'])) {
    echo "ID de usuario: " . $_SESSION['user_id'] . "<br>";
} else {
    echo "Variable 'user_id' no establecida.<br>";
}

if (isset($_SESSION['user_rol'])) {
    echo "Rol de usuario: " . $_SESSION['user_rol'] . "<br>";
} else {
    echo "Variable 'user_rol' no establecida.<br>";
}

// También puedes ver todas las variables de sesión para depuración
echo "--- Todas las variables de sesión ---<br>";
print_r($_SESSION);
?>