<?php
// prueba_conexion.php

// 1. Incluimos tu archivo de conexión actual
require_once "includes/conexion.php"; 

echo "<h1>🔍 Prueba de Diagnóstico de Conexión</h1>";
echo "<hr>";

// 2. Verificar si la conexión ($conn) que viene del include es válida
if ($conn->connect_error) {
    echo "<h2 style='color:red'>❌ FALLÓ LA CONEXIÓN</h2>";
    echo "<p><strong>Error reportado:</strong> " . $conn->connect_error . "</p>";
    exit(); // Detenemos todo si no hay conexión
} else {
    echo "<h2 style='color:green'>✅ ¡CONEXIÓN EXITOSA!</h2>";
    echo "<p>Se ha logrado entrar al servidor remoto.</p>";
    echo "<p><strong>Host:</strong> " . $conn->host_info . "</p>";
}

echo "<hr>";
echo "<h3>📂 Listando lo que se encontró en la base de datos 'wiznet':</h3>";

// 3. La orden del jefe: "Que liste lo que encuentre"
// Vamos a pedirle a la base de datos que nos muestre todas sus tablas
$sql = "SHOW TABLES";
$resultado = $conn->query($sql);

if ($resultado) {
    $numero_tablas = $resultado->num_rows;
    echo "<p>Se encontraron <strong>$numero_tablas</strong> tablas:</p>";
    
    if ($numero_tablas > 0) {
        echo "<ul>";
        // Recorremos y mostramos cada tabla encontrada
        while ($fila = $resultado->fetch_array()) {
            echo "<li>" . $fila[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:orange'>La conexión funciona, pero la base de datos está vacía (no tiene tablas).</p>";
    }
} else {
    echo "<p style='color:red'>Error al intentar listar las tablas: " . $conn->error . "</p>";
}

echo "<hr>";
echo "<p><em>Fin del diagnóstico.</em></p>";
?>