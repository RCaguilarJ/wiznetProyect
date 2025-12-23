<?php
// Central config with env overrides. Optional .env loader for cPanel setups.

$env_path = __DIR__ . "/.env";
if (is_readable($env_path)) {
    $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === "" || strpos($line, "#") === 0) {
            continue;
        }
        $parts = explode("=", $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            if ($value !== "" && $value[0] === '"' && substr($value, -1) === '"') {
                $value = substr($value, 1, -1);
            }
            if (getenv($key) === false) {
                putenv($key . "=" . $value);
            }
        }
    }
}

$default_host = "localhost";
$default_user = "root";
$default_pass = "";
$default_db   = "wiznet_wiznet";
$default_port = "3306";

return [
    "db" => [
        "host" => getenv("DB_HOST") ?: $default_host,
        "user" => getenv("DB_USER") ?: $default_user,
        "pass" => getenv("DB_PASS") ?: $default_pass,
        "name" => getenv("DB_NAME") ?: $default_db,
        "port" => (int) (getenv("DB_PORT") ?: $default_port),
        "charset" => getenv("DB_CHARSET") ?: "utf8",
        // SSL (optional). Provide paths to enable SSL.
        "ssl_ca" => getenv("DB_SSL_CA") ?: "",
        "ssl_cert" => getenv("DB_SSL_CERT") ?: "",
        "ssl_key" => getenv("DB_SSL_KEY") ?: "",
        "ssl_verify" => getenv("DB_SSL_VERIFY") ?: "1",
    ],
];
