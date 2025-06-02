<?php
require_once('../database/conexion.php');

if (isset($_POST['correo']) && isset($_POST['clave'])) {
    $correo = $_POST['correo'];

    $contrasena = $_POST['clave'];
    $consultaCompany = "SELECT company_password,company_email FROM companies WHERE company_password = '$contrasena' AND company_email = '$correo'";
    $consultaStudent = "SELECT student_email,student_password FROM student WHERE student_email = '$correo' AND student_password = '$contrasena'";


    $resultCompany = $conexion -> query($consultaCompany);
    $resultStudent= $conexion -> query($consultaStudent);


    if ($resultCompany -> num_rows > 0) {
        echo"1";
    }else if($resultStudent -> num_rows > 0){
        echo"2";
    }else{
        echo"0";
    }

}

