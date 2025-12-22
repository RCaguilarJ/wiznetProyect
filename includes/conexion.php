<?php


$host = "localhost";
$user = "root";      
$password = "";      
$database = "wiznet";

// Intentar conectar
$conn = new mysqli($host, $user, $password, $database);

// Verificar si hubo error
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar caracteres a UTF-8 para que se vean bien las tildes y ñ
$conn->set_charset("utf8");

// Iniciar sesión en todos los archivos que usen esta conexión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>