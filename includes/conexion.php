<?php
// archivo: includes/conexion.php

// ====================================================
//  INTERRUPTOR DE ENTORNO
// ====================================================
// true  = Modo Local (Tu PC)
// false = Modo Producción (Servidor Real)

$modo_local = true;  // <--- ¡LISTO PARA ENVIAR! (En false)

            
if ($modo_local) {
    //  CONFIGURACIÓN LOCAL (Tu PC)
    $host = "localhost";
    $user = "root";
    $password = ""; 
    $database = "wiznet"; 

// } else {
    //  CONFIGURACIÓN PRODUCCIÓN (IP Específica)
    // $host = "162.240.228.124"; 
    // $user = "wiznet_wiznet";
    // $password = 'YI13$~PNk@#z'; 
    // $database = "wiznet_wiznet";
}

// ====================================================
//  CREAR CONEXIÓN
// ====================================================
$conn = @new mysqli($host, $user, $password, $database);

// Verificar errores
if ($conn->connect_error) {
    if ($modo_local) {
        die("❌ Error LOCAL: " . $conn->connect_error);
    } else {
    
        die("Error de conexión al sistema. ");
    }
}

$conn->set_charset("utf8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>