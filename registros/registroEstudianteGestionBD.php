<?php
require_once('../database/conexion.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correoEstudiante = $_POST['correoEstudiante'];
$clave = $_POST['contresena'];
$telefono = $_POST['telefono'];
$cedula = $_POST['cedula'];
$educacion = $_POST['educacion'];
$resumen = $_POST['resumen'];
$portafolio = $_POST['portafolio'];
$sintesis = $_POST['sintesis'];
$habilidades = $_POST['habilidades'];
$sexo = $_POST['sexo'];
$fechaNacimiento = $_POST['fechaNacimiento'];

$rol = "1";


// datos de ubicaion

$estado = $_POST['estado'];
$parroquia = $_POST['parroquia'];
$sector = $_POST['sectore'];
$calle = $_POST['calle'];

// prueba de que lleguen los datos
//echo $nombre . " " . $apellido . " " . $correoEstudiante . " " . $clave . " " . $telefono . " " . $cedula . " " . $educacion . " " . $resumen . " " . $portafolio . " " . $sintesis . " " . $habilidades . " " . $sexo . " " . $estado . " " . $parroquia . " " . $sector . " " . $calle;

$imageData = null; // Inicializar en null
$imageType = null; // Inicializar en null

if (isset($_FILES['imagenEstudiante']) && $_FILES['imagenEstudiante']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['imagenEstudiante']['tmp_name'];
    $fileSize = $_FILES['imagenEstudiante']['size'];
    $fileType = $_FILES['imagenEstudiante']['type']; // Tipo MIME (image/jpeg, image/png, etc.)

    // Validaciones básicas para la imagen
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    // El límite para MEDIUMBLOB es 16MB (16 * 1024 * 1024 bytes)
    $maxFileSize = 16 * 1024 * 1024; 

    if (!in_array($fileType, $allowedTypes)) {
        echo "11e"; // Código de error para tipo de archivo no permitido
        $conexion->close();
        exit();
    } elseif ($fileSize > $maxFileSize) {
        echo "10e"; // Código de error para tamaño de imagen excedido
        $conexion->close();
        exit();
    } else {
        // Leer el contenido binario del archivo solo si las validaciones pasan
        $imageData = file_get_contents($fileTmpPath);
        $imageType = $fileType; // Guardar el tipo MIME para la DB
    }
} else if (isset($_FILES['imagenEstudiante']) && $_FILES['imagenEstudiante']['error'] !== UPLOAD_ERR_NO_FILE) {
    // Si hubo un error en la subida que no sea "no se seleccionó archivo"
    echo "0"; // Otro error en la subida de la imagen
    $conexion->close();
    exit();
}


$queryValidacion = "SELECT student_identy_card, student_email, student_phone  FROM student WHERE student_identy_card = ? OR student_email = ? OR student_phone = ?";
$stmtValidacion = $conexion->prepare($queryValidacion);

if (!$stmtValidacion) {
    echo "0" . $conexion->error ; // Error al preparar la consulta de validación
    $conexion->close();
    exit(); 
}

$stmtValidacion->bind_param("sss", $cedula, $correoEstudiante, $telefono); // Vincula los parámetros para la validación
$stmtValidacion->execute();
$stmtValidacion->store_result();

if ($stmtValidacion->num_rows > 0) {
    echo "12e"; // La cedula  o el Correo ya están registrados.
    $stmtValidacion->close();
    $conexion->close();
    exit();
}
$stmtValidacion->close(); 

$insertStudentQuery = "INSERT INTO `student` (
    `studen_name`,
    `student_lastname`,
    `student_identy_card`,
    `student_email`,
    `student_password`,
    `student_skills`,
    `education_level`,
    `student_phone`,
    `date_of_birth`, 
    `portfolio`,
    `student_sex`,
    `curriculum_vitae`,
    `summary`,
    `role_id`,
    `img_profile`,
    `img_perfil_type`
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmtStudent = $conexion->prepare($insertStudentQuery);

if (!$stmtStudent) {
    echo "0" . $conexion->error;
    $conexion->close();
    exit();
}

// Vincula los parámetros para la tabla `Student`
$contrasena_hash = password_hash($clave, PASSWORD_DEFAULT); // Hashea la contraseña
$stmtStudent->bind_param("sssssssssssssisb",
    $nombre,
    $apellido,
    $cedula,
    $correoEstudiante,
    $contrasena_hash, // Recuerda hashear esto
    $habilidades,
    $educacion,
    $telefono,
    $fechaNacimiento,
    $portafolio,
    $sexo,
    $sintesis,
    $resumen,
    $rol,
    $imageData,
    $imageType
);


if ($stmtStudent->execute()) {
    $student_id = $conexion->insert_id;
    $stmtStudent->close(); // Cierra la sentencia de la compañía

    // --- 5. Inserción de Datos de la Dirección Usando el ID de la Compañía ---
    $insertAddressQuery = "INSERT INTO `student_address` (
        `state`,
        `parish`,
        `sector`,
        `street`,
        `id_student`
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
        $student_id 
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