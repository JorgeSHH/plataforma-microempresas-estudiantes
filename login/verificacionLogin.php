<?php
// Activar reporte de errores para desarrollo (quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar que no haya salida antes de los headers
if (ob_get_length()) ob_clean();

header('Content-Type: application/json');
session_start();

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'error' => 'Método no permitido']));
}

// Validar datos de entrada
if (empty($_POST['correo']) ){
    die(json_encode(['success' => false, 'error' => 'El correo es requerido']));
}

if (empty($_POST['clave'])) {
    die(json_encode(['success' => false, 'error' => 'La contraseña es requerida']));
}

// Conexión a la base de datos
try {
    require __DIR__ . '/../config/database.php';
    
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['clave']);

    // Buscar en estudiantes
    $stmt = $pdo->prepare("SELECT id_student, student_password FROM student WHERE student_email = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $tipo = 'estudiante';

    // Si no es estudiante, buscar en empresas
    if (!$usuario) {
        $stmt = $pdo->prepare("SELECT id_company, company_password FROM companies WHERE company_email = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $tipo = 'empresa';
    }

    // Verificar usuario y contraseña
    if (!$usuario) {
        die(json_encode(['success' => false, 'error' => 'Usuario no encontrado']));
    }

    $passwordField = ($tipo === 'estudiante') ? 'student_password' : 'company_password';
    
    // Comparación directa (deberías usar password_verify si las contraseñas están hasheadas)
    if ($clave !== $usuario[$passwordField]) {
        die(json_encode(['success' => false, 'error' => 'Credenciales incorrectas']));
    }

    // Login exitoso
    $_SESSION['user_id'] = ($tipo === 'estudiante') ? $usuario['id_student'] : $usuario['id_company'];
    $_SESSION['user_type'] = $tipo;
    $_SESSION['user_email'] = $correo;

    echo json_encode([
        'success' => true,
        'user_type' => $tipo,
        'redirect' => ($tipo === 'estudiante') ? '../estudiante/dashboard.php' : '../empresa/dashboard.php'
    ]);
    exit;

} catch (PDOException $e) {
    error_log('Error de base de datos: ' . $e->getMessage());
    die(json_encode(['success' => false, 'error' => 'Error en el servidor']));
} catch (Exception $e) {
    error_log('Error general: ' . $e->getMessage());
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}