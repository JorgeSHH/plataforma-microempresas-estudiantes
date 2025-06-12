<?php

session_start();

require_once('../database/conexion.php');

if ($conexion->connect_error) {
    error_log("Error de conexión a la base de datos: " . $conexion->connect_error);
    echo "0"; // Indica un error si la conexión falla
    exit();
}

if (isset($_POST['correo']) && isset($_POST['clave'])) {
    $correo = $_POST['correo'];
    $contrasena_ingresada = $_POST['clave']; // La contraseña tal cual la ingresó el usuario

    // --- Parte 1: Intentar buscar en la tabla de empresas ---
    // Usar consultas preparadas para mayor seguridad (previene inyección SQL)
    $stmtCompany = $conexion->prepare("SELECT id_company, company_password FROM companies WHERE company_email = ?");
    if ($stmtCompany === false) {
        error_log("Error en la preparación de la consulta de empresa: " . $conexion->error);
        echo "0"; // Indica un error si la preparación de la consulta falla
        exit();
    }
    $stmtCompany->bind_param("s", $correo); // "s" indica que el parámetro es una cadena (string)
    $stmtCompany->execute();
    $stmtCompany->store_result(); // Almacena los resultados para poder usar num_rows
    $stmtCompany->bind_result($company_id, $company_password_hash); // Vincula las columnas a variables

    if ($stmtCompany->num_rows > 0) {
        $stmtCompany->fetch(); // Obtiene los valores vinculados a las variables
        // Se encontró una empresa con el correo, ahora verifica la contraseña hasheada
        if (password_verify($contrasena_ingresada, $company_password_hash)) {
            // Contraseña correcta para la empresa
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $company_id; // Guarda el ID de la empresa
            $_SESSION['user_rol'] = 'empresa'; // Establece el rol
            echo "1"; // Redirigir a dashboard de empresa
            $stmtCompany->close();
            $conexion->close();
            exit();
        }
    }
    $stmtCompany->close(); // Cierra el statement después de usarlo

    // --- Parte 2: Si no es una empresa o la contraseña no coincide, intentar buscar en la tabla de estudiantes ---
    $stmtStudent = $conexion->prepare("SELECT id_student, student_password FROM student WHERE student_email = ?");
    if ($stmtStudent === false) {
        error_log("Error en la preparación de la consulta de estudiante: " . $conexion->error);
        echo "0"; // Indica un error si la preparación de la consulta falla
        exit();
    }
    $stmtStudent->bind_param("s", $correo); // "s" indica que el parámetro es una cadena (string)
    $stmtStudent->execute();
    $stmtStudent->store_result(); // Almacena los resultados para poder usar num_rows
    $stmtStudent->bind_result($student_id, $student_password_hash); // Vincula las columnas a variables

    if ($stmtStudent->num_rows > 0) {
        $stmtStudent->fetch(); // Obtiene los valores vinculados a las variables
        // Se encontró un estudiante con el correo, ahora verifica la contraseña hasheada
        if (password_verify($contrasena_ingresada, $student_password_hash)) {
            // Contraseña correcta para el estudiante
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $student_id; // Guarda el ID del estudiante
            $_SESSION['user_rol'] = 'estudiante'; // Establece el rol
            echo "2"; // Redirigir a dashboard de estudiante
            $stmtStudent->close();
            $conexion->close();
            exit();
        }
    }
    $stmtStudent->close(); // Cierra el statement después de usarlo

    // Si llegó hasta aquí, significa que el correo no se encontró o la contraseña fue incorrecta en ambos casos
    echo "0"; // Error de credenciales
    $conexion->close(); // Cierra la conexión al finalizar
    exit();

} else {
    // Si no se recibieron correo y clave (acceso directo al script sin POST)
    echo "0"; // Indicar error
    exit();
}