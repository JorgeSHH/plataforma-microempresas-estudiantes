<?php
if (isset($_POST)){
    require("../config/database.php");
    $correo = $_POST['correo_empresa'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $contrasena = $_POST['contrasena'];
    $telefono = $_POST['telefono'];
    $rif = $_POST['rif'];
    $tipo_contrato = $_POST['opciones'];
    // $estado = $_POST['estado'];
    // $parroquia = $_POST['parroquia'];
    // $sector = $_POST['sector'];
    // $calle = $_POST['calle'];
    $requisitos = $_POST['requisitos'];

    $queryConfirmacionEmail = $pdo->prepare("SELECT * FROM companies WHERE company_email = :cor");
    $queryConfirmacionEmail->bindParam(":cor", $correo);
    $queryConfirmacionEmail->execute();
    $resultadoEmail =  $queryConfirmacionEmail->fetch(PDO::FETCH_ASSOC);
    if ($resultadoEmail) {
        echo "correo";
        exit;
    }
    $queryConfirmacionRif = $pdo->prepare("SELECT * FROM companies WHERE company_rif = :rif");
    $queryConfirmacionRif->bindParam(":rif", $rif);
    $queryConfirmacionRif->execute();
    $resultadoRif =  $queryConfirmacionRif->fetch(PDO::FETCH_ASSOC);
    if ($resultadoRif) {
        echo "rif";
        exit;
    }

    $query = $pdo->prepare("INSERT INTO companies (company_password, company_name, company_rif, company_email, company_phone, job_requirements, contract_type) VALUES (:con, :nom, :rif, :cor, :tel, :req, :tip)");
    $query->bindParam(":con", $contrasena);
    $query->bindParam(":nom", $nombre_empresa);
    $query->bindParam(":rif", $rif);
    $query->bindParam(":cor", $correo);
    $query->bindParam(":tel", $telefono);
    $query->bindParam(":req", $requisitos);
    $query->bindParam(":tip", $tipo_contrato);
    $query->execute();
    $pdo = null;
    echo "ok";
}
    

