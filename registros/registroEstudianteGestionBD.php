<?php
require_once('../database/conexion.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correoEstudiante = $_POST['correoEstudiante'];
$clave = $_POST['contresena'];
$telefono = $_POST['telefono'];
$cedula = $_POST['cedula'];
$requisitos = $_POST['requisitos'];
$rol = "1";


// datos de ubicaion

$estado = $_POST['estado'];
$parroquia = $_POST['parroquia'];
$sector = $_POST['sector'];
$calle = $_POST['calle'];


// aqui va lo de las imagenes

$queryValidacion = "SELECT student_identy_card, student_email FROM student WHERE student_identy_card = ? OR student_email = ?";
$stmtValidacion = $conexion->prepare($queryValidacion);

if (!$stmtValidacion) {
    echo "0" . $conexion->error ; // Error al preparar la consulta de validación
    $conexion->close();
    exit(); 
}

$stmtValidacion->bind_param("ss", $cedula, $correoEstudiante);
$stmtValidacion->execute();
$stmtValidacion->store_result();

if ($stmtValidacion->num_rows > 0) {
    echo "12e"; // La cedula  o el Correo ya están registrados.
    $stmtValidacion->close();
    $conexion->close();
    exit();
}
$stmtValidacion->close(); 

