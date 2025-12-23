<?php
// archivo: includes/conexion.php

$config = require __DIR__ . "/../config.php";
$db = $config["db"];

$conn = mysqli_init();
$client_flags = 0;

if (!empty($db["ssl_ca"])) {
    $conn->ssl_set(
        $db["ssl_key"],
        $db["ssl_cert"],
        $db["ssl_ca"],
        null,
        null
    );
    $client_flags |= MYSQLI_CLIENT_SSL;
}

$conn->real_connect(
    $db["host"],
    $db["user"],
    $db["pass"],
    $db["name"],
    $db["port"],
    null,
    $client_flags
);

if ($conn->connect_error) {
    die("Error de conexion al sistema.");
}

$conn->set_charset($db["charset"]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
