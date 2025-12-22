<?php
// includes/conexion.php

// Detectamos si estamos en local (tu WAMP) o en Producción
$es_local = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1');

if ($es_local) {

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "wiznet"; 

} else {

    $host = "187.189.95.34";  
    $user = "wiznet_wiznet";
    $password = "YI13$~PNk@#z";
    $database = "wiznet_wiznet";
    

}

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar errores
if ($conn->connect_error) {
    
    die("Error de conexión al sistema.");
}

$conn->set_charset("utf8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>