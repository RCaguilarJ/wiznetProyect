<?php


// 1. Conexión (si no existe)
if (!isset($conn)) {
    if (file_exists("includes/conexion.php")) require_once "includes/conexion.php";
    elseif (file_exists("../includes/conexion.php")) require_once "../includes/conexion.php";
}

// 2. Verificar que recibimos un ID
if (!isset($_GET['id'])) {
    echo "<script>alert('No se especificó un cliente.'); window.location.href='dashboard.php?vista=clientes';</script>";
    exit;
}

$id_cliente = $conn->real_escape_string($_GET['id']);
$mensaje = "";

// --- PARTE A: PROCESAR EL FORMULARIO (UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y limpiar datos
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $numero = $conn->real_escape_string($_POST['numero']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $nota = $conn->real_escape_string($_POST['nota']);

    // Query de Actualización
    $sql_update = "UPDATE clientes SET 
                   nombre = '$nombre', 
                   numero = '$numero', 
                   telefono_1 = '$telefono', 
                   direccion = '$direccion',
                   nota = '$nota'
                   WHERE id = '$id_cliente'";

    if ($conn->query($sql_update) === TRUE) {
        $mensaje = "Cliente actualizado correctamente.";
        
    } else {
        $mensaje = "Error al actualizar: " . $conn->error;
    }
}

// --- OBTENER DATOS ACTUALES (SELECT) ---
$sql_select = "SELECT * FROM clientes WHERE id = '$id_cliente' LIMIT 1";
$resultado = $conn->query($sql_select);

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();
} else {
    echo "Cliente no encontrado.";
    exit;
}
?>

<style>
    .edit-wrapper { max-width: 800px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    
    .form-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }

    .form-group label {
        font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; display: block;
    }
    .form-control {
        background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px;
        padding: 12px; width: 100%; box-sizing: border-box; color: #334155; font-size: 0.95rem;
    }
    .form-control:focus { outline: none; border-color: #3B82F6; background-color: white; }

    .btn-row { display: flex; gap: 15px; margin-top: 25px; }
    
    /* Botón Guardar (Azul corporativo o Negro según prefieras) */
    .btn-save {
        background-color: #0F172A; color: white; border: none; padding: 12px 25px;
        border-radius: 6px; font-weight: 600; cursor: pointer; flex: 1;
    }
    .btn-save:hover { background-color: #1e293b; }

    /* Botón Cancelar */
    .btn-cancel {
        background-color: white; border: 1px solid #e2e8f0; color: #64748B;
        padding: 12px 25px; border-radius: 6px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center;
    }
    .btn-cancel:hover { background-color: #f1f5f9; color: #333; }

    .alert-box {
        padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;
        background-color: #DCFCE7; color: #166534; border: 1px solid #bbf7d0;
    }
    @media (max-width: 900px) {
        .edit-wrapper { padding: 0 15px; }
        .form-card { padding: 20px; }
    }
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .full-width { grid-column: span 1; }
        .btn-row { flex-direction: column; }
    }
</style>

<div class="edit-wrapper view-shell">

    <div class="page-header">
        <h2 style="margin:0; color:#1e293b;">Editar Cliente</h2>
        <p style="margin:5px 0 0 0; color:#64748B;">Modifica los datos del cliente seleccionado</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert-box">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="" method="POST">
            
            <div class="form-grid">
                
                <div class="form-group full-width">
                    <label>Nombre Completo *</label>
                    <input type="text" name="nombre" class="form-control" required 
                           value="<?php echo htmlspecialchars($cliente['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label>Número de Cliente / Contrato</label>
                    <input type="text" name="numero" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['numero']); ?>">
                </div>

                <div class="form-group">
                    <label>Teléfono Principal</label>
                    <input type="text" name="telefono" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['telefono_1']); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Dirección de Servicio</label>
                    <input type="text" name="direccion" class="form-control" 
                           value="<?php echo htmlspecialchars($cliente['direccion']); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Notas Internas</label>
                    <textarea name="nota" class="form-control" rows="3"><?php echo htmlspecialchars($cliente['not']); // Nota: En tu imagen dice 'nota' o 'not'? Ajustar según BD ?></textarea>
                    </div>

            </div>

            <div class="btn-row">
                <button type="submit" class="btn-save">Guardar Cambios</button>
                <a href="dashboard.php?vista=clientes" class="btn-cancel">Cancelar</a>
            </div>

        </form>
    </div>

</div>
