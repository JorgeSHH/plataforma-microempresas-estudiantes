<?php
require_once('../database/conexion.php');

$correo = $_POST['correo-empresa'];
$nombre = $_POST['nombre-empresa'];
$clave = $_POST['contresena']; // ¡Recordatorio: Hashea esta clave!
$telefono = $_POST['telf'];
$rif = $_POST['rif'];
$tipoContrato = $_POST['opciones'];
$requisitos = $_POST['requisitos'];
$rol = "2";

//encriptar la contrasena
$contrasena_hash = password_hash($clave, PASSWORD_DEFAULT);


$estado = $_POST['estado'];
$parroquia = $_POST['parroquia'];
$sector = $_POST['sector'];
$calle = $_POST['calle'];


$queryValidacion = "SELECT company_rif, company_email FROM companies WHERE company_rif = ? OR company_email = ?";
$stmtValidacion = $conexion->prepare($queryValidacion);

if (!$stmtValidacion) {
    echo "0" . $conexion->error;
    $conexion->close();
    exit(); 
}

$stmtValidacion->bind_param("ss", $rif, $correo);
$stmtValidacion->execute();
$stmtValidacion->store_result();

if ($stmtValidacion->num_rows > 0) {
    echo "12e"; // El RIF o el Correo ya están registrados.
    $stmtValidacion->close();
    $conexion->close();
    exit();
}
$stmtValidacion->close(); // Cierra la sentencia de validación

$insertCompanyQuery = "INSERT INTO `companies` (
    `company_password`,
    `company_name`,
    `company_rif`,
    `company_email`,
    `company_phone`,
    `job_requirements`,
    `contract_type`,
    `role_id`
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmtCompany = $conexion->prepare($insertCompanyQuery);

if (!$stmtCompany) {
    echo "0" . $conexion->error;
    $conexion->close();
    exit();
}

// Vincula los parámetros para la tabla `companies`
$stmtCompany->bind_param("ssssssss",
    $contrasena_hash,       // Recuerda hashear esto
    $nombre,
    $rif,
    $correo,
    $telefono,
    $requisitos,
    $tipoContrato,
    $rol
);

if ($stmtCompany->execute()) {
    $company_id = $conexion->insert_id;
    $stmtCompany->close(); // Cierra la sentencia de la compañía

    // --- 5. Inserción de Datos de la Dirección Usando el ID de la Compañía ---
    $insertAddressQuery = "INSERT INTO `company_address` (
        `state`,
        `parish`,
        `sector`,
        `street`,
        `id_company`
    ) VALUES (?, ?, ?, ?, ?)";

    $stmtAddress = $conexion->prepare($insertAddressQuery);

    if (!$stmtAddress) {
        echo "0" . $conexion->error;
        $conexion->close();
        exit();
    }

    $stmtAddress->bind_param("ssssi",
        $estado,
        $parroquia,
        $sector,
        $calle,
        $company_id // ¡Aquí se usa el ID de la compañía!
    );

    if ($stmtAddress->execute()) {
        echo "1"; // Indica éxito completo del registro
    } else {
        echo "0" . $stmtAddress->error;
    }
    $stmtAddress->close(); // Cierra la sentencia de la dirección

} else {
    echo "0" . $stmtCompany->error;
}

$conexion->close(); // Cierra la conexión a la base de datos