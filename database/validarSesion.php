<?php
session_start();
//echo $_SESSION['user'];

if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
}
