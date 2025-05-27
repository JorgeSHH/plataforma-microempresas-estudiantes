<?php

     $servidor = 'mysql:dbname=platafordb;host=localhost';
     $username = 'root'; 
     $password = ''; 

try {
   $pdo = new PDO($servidor, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
   echo "connexion fallida" .$e->getMessage();
}


