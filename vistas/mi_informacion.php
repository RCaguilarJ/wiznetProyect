// vistas/mi_informacion.php CORREGIDO:

// Lógica de Cambio de Contraseña REAL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_pass') {
    $pass_nueva = $_POST['new_password'];
    $pass_conf = $_POST['confirm_password'];

    if ($pass_nueva === $pass_conf) {
        // AQUI FALTABA EL UPDATE SQL
        $pass_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);
        // Asegúrate de usar la columna 'password' (o 'clave' si es diferente en tu BD)
        $sql_upd = "UPDATE clientes SET password = '$pass_hash' WHERE id = '$id_usuario'";
        
        if($conn->query($sql_upd)){
            $mensaje = "✅ Contraseña actualizada correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error DB: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Las contraseñas no coinciden.";
        $tipo_mensaje = "error";
    }
}