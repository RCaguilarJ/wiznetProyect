<?php
// archivo: includes/conexion.php

// ====================================================
// 🎛️ INTERRUPTOR DE ENTORNO
// ====================================================
// true  = Modo Local (WAMP/XAMPP)
// false = Modo Producción (Servidor Real)

$modo_local = false;  // <--- ¡LISTO PARA PRODUCCIÓN!


if ($modo_local) {
    // 🏠 CONFIGURACIÓN LOCAL (Tu PC)
    $host = "localhost";
    $user = "root";
    $password = ""; 
    $database = "wiznet_wiznet"; 

} else {
    // CONFIGURACIÓN PRODUCCIÓN (Credenciales Oficiales)
    $host = "187.189.95.34"; 
    $user = "wiznet_wiznet";
   
    $password = 'YI13$~PNk@#z'; 
    $database = "wiznet_wiznet";
}


// ====================================================
// Usamos el @ para manejar los errores nosotros mismos
$conn = @new mysqli($host, $user, $password, $database);

// Verificar errores
if ($conn->connect_error) {
    if ($modo_local) {
        die("❌ Error de conexión LOCAL: " . $conn->connect_error);
    } else {
        // En producción mostramos un mensaje genérico por seguridad, 

        die("Error de conexión al sistema de Wiznet. ");
    }
}

// Configurar caracteres especiales (tildes, ñ)
$conn->set_charset("utf8");

// Iniciar sesión globalmente
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>