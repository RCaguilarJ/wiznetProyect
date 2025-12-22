<?php
// archivo: index.php
// 1. Incluimos la conexión a la base de datos
require_once "includes/conexion.php";

// Variable para errores
$mensaje_error = "";

// 2. Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpieza básica
    $correo = $conn->real_escape_string($_POST['email']);
    $password_ingresado = $_POST['password'];

    // 3. Consulta SQL
    $sql = "SELECT * FROM usuarios WHERE email = '$correo' LIMIT 1";
    $resultado = $conn->query($sql);

    // 4. Verificar si el usuario existe
    if ($resultado && $resultado->num_rows > 0) {
        
        // Obtenemos los datos del usuario
        $usuario_db = $resultado->fetch_assoc();
        $password_db = $usuario_db['password']; // La contraseña guardada en la BD

        
        // Esto probará los 3 métodos posibles automáticamente
        $login_exitoso = false;

        
        if (password_verify($password_ingresado, $password_db)) {
            $login_exitoso = true;
        } 
        
        elseif (md5($password_ingresado) === $password_db) {
            $login_exitoso = true;
        } 
        
        elseif ($password_ingresado === $password_db) {
            $login_exitoso = true;
        }

        
        if ($login_exitoso) {
            
            $_SESSION['usuario_id'] = $usuario_db['id'];
            $_SESSION['nombre'] = $usuario_db['nombre'];
            
            if(isset($usuario_db['rol'])) {
                $_SESSION['rol'] = $usuario_db['rol'];
            }

            // Redirección al Dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $mensaje_error = "La contraseña es incorrecta.";
        }

    } else {
        $mensaje_error = "No existe una cuenta con el correo: " . htmlspecialchars($correo);
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
            <img src="assets/img/logo.png" alt="Wiznet" class="login-logo">
            <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 10px; display:flex; align-items:center; justify-content:center; gap:10px;">
                <i class="fa-solid fa-circle-nodes" style="color: #3B82F6;"></i> 
            </div>
            
            <p style="color: #64748B; font-size: 0.9rem; margin-bottom: 30px;">Inicia sesión en tu cuenta</p>
            <?php if(!empty($mensaje_error)): ?>
                <div style="background:#fee2e2; color:#dc2626; padding:10px; border-radius:6px; margin-bottom:15px; font-size:0.9rem; text-align: left;">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
            <form action="index.php" method="POST"> 
                
                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="tu@email.com" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <div style="position:relative;">
                        <input type="password" name="password" class="form-control" placeholder="........" required>
                        <i class="fa-regular fa-eye" style="position:absolute; right:15px; top:12px; color:#999; cursor:pointer;"></i>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Iniciar Sesión</button>
            </form>
            
        </div>
    </div>

</body>
</html>
