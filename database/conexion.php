<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'platafordb');



$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// codigo de prueba para ver si hay un error 
// if ($conexion->connect_error) {
//     die("Error de conexion:" . $conexion->connect_error);
// } else{
//      echo "¡Conexión exitosa a la base de datos!";
// }