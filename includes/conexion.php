<?php
// includes/conexion.php

// Detectamos si es entorno local
$es_local = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1');

if ($es_local) {
    // ==========================================
    // MODO DE ESPERA (TRABAJO LOCAL EN TU WAMP)
    // ==========================================
    $host = "localhost";
    $user = "root";       
    $password = "";       
    $database = "wiznet"; 

  

} else {
 
    $host = "localhost"; 
    $user = "usuario_del_hosting"; 
    $password = "contraseña_del_hosting";      
    $database = "wiznet";
}

// Conexión
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>