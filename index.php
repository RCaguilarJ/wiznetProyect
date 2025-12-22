<?php
// archivo: index.php
require_once "includes/conexion.php";

$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $correo = $conn->real_escape_string($_POST['email']);
    $password_ingresado = $_POST['password'];

    
    $tabla_clientes = "clientes"; 
    
    
    $col_id       = "id";
    $col_email    = "email";     
    $col_password = "password";  
    $col_nombre   = "nombre";   

    // 1. Buscamos al usuario
    $sql = "SELECT * FROM $tabla_clientes WHERE $col_email = '$correo' LIMIT 1";
    
    // Ejecutamos la consulta
    $resultado = $conn->query($sql);
    
    if (!$resultado) {
        // Si hay un error SQL (ej. tabla no existe), lo mostramos para depurar
        $mensaje_error = "Error Técnico: " . $conn->error;
    }
    elseif ($resultado->num_rows > 0) {
        
        $datos_usuario = $resultado->fetch_assoc();
        
        // 2. Verificar Contraseña
        if (isset($datos_usuario[$col_password])) {
            
            $password_db = $datos_usuario[$col_password];
            $login_exitoso = false;

            // Probamos los métodos de contraseña
            if (password_verify($password_ingresado, $password_db)) {
                $login_exitoso = true;
            } elseif (md5($password_ingresado) === $password_db) {
                $login_exitoso = true;
            } elseif ($password_ingresado === $password_db) {
                $login_exitoso = true;
            }

            if ($login_exitoso) {
                // 3. Login Correcto
                $_SESSION['usuario_id'] = $datos_usuario[$col_id];
                $_SESSION['nombre'] = $datos_usuario[$col_nombre];
                
                // Redirigir al Dashboard
                header("Location: dashboard.php");
                exit();

            } else {
                $mensaje_error = "La contraseña es incorrecta.";
            }

        } else {
            $mensaje_error = "Error de configuración: La columna de contraseña no existe.";
        }

    } else {
        $mensaje_error = "No existe una cuenta registrada con este correo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Wiznet</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <img src="assets/img/logo.png" alt="Wiznet" class="login-logo" style="max-width: 150px; margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;">
            
            <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 10px; display:flex; align-items:center; justify-content:center; gap:10px;">
                <i class="fa-solid fa-circle-nodes" style="color: #3B82F6;"></i> WIZNET
            </div>
            
            <p style="color: #64748B; font-size: 0.9rem; margin-bottom: 30px; text-align: center;">Acceso a Clientes</p>

            <?php if(!empty($mensaje_error)): ?>
                <div style="background:#fee2e2; color:#dc2626; padding:10px; border-radius:6px; margin-bottom:15px; font-size:0.9rem;">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST"> 
                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="cliente@email.com" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <div style="position:relative;">
                        <input type="password" name="password" class="form-control" placeholder="........" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
</body>
</html>