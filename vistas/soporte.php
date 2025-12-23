<?php
// --- LÓGICA BACKEND ---

// Validamos sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_mensaje = "";

// 1. OBTENER DATOS REALES DEL CLIENTE (Bloqueados para edición)
// Usamos la tabla 'clientes' y la columna 'correo'
$sql_cliente = "SELECT nombre, correo, telefono_1, numero FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$cliente = ($res_cliente && $res_cliente->num_rows > 0) ? $res_cliente->fetch_assoc() : [];

// Variables para el formulario (usamos null coalescing operator ?? para evitar errores)
$nombre_fijo = $cliente['nombre'] ?? 'Usuario';
$correo_fijo = $cliente['correo'] ?? 'Sin correo';
$tel_fijo    = $cliente['telefono_1'] ?? 'Sin teléfono';
$num_fijo    = $cliente['numero'] ?? '---';


// 2. PROCESAR CREACIÓN DE TICKET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Solo tomamos los campos que el usuario SÍ puede editar
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $prioridad = $conn->real_escape_string($_POST['prioridad']);
    $asunto = $conn->real_escape_string($_POST['asunto']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);

    if(!empty($asunto) && !empty($descripcion)) {
        // El ID del cliente lo sacamos de la sesión, NO del formulario (seguridad)
        $sql_insert = "INSERT INTO tickets (fk_cliente, categoria, prioridad, asunto, descripcion, estatus, fecha_registro) 
                       VALUES ('$id_usuario', '$categoria', '$prioridad', '$asunto', '$descripcion', 'Pendiente', NOW())";
        
        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Ticket creado exitosamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error al crear ticket: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Por favor llene el asunto y la descripción.";
        $tipo_mensaje = "error";
    }
}

// 3. CONSULTAR HISTORIAL
$sql_historial = "SELECT * FROM tickets WHERE fk_cliente = '$id_usuario' ORDER BY fecha_registro DESC";
$res_tickets = $conn->query($sql_historial);
?>

<style>
    /* Estilos para campos bloqueados */
    .input-locked { 
        background-color: #f1f5f9 !important; 
        color: #64748B !important; 
        cursor: not-allowed !important; 
        border: 1px solid #e2e8f0;
    }
    
    /* Resto de estilos del formulario */
    .support-wrapper { max-width: 1000px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-control { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; }
    .btn-dark { background-color: #0F172A; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; }
    
    /* Tickets */
    .ticket-item { border: 1px solid #f1f5f9; border-radius: 8px; padding: 15px; margin-bottom: 10px; }
    .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; }
    .st-Pendiente { background: #FEF9C3; color: #CA8A04; }
    .st-Resuelto { background: #DCFCE7; color: #16A34A; }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>

<div class="support-wrapper">
    <div class="page-header">
        <h2>Soporte Técnico</h2>
        <p>Cree un ticket de soporte o consulte sus tickets existentes</p>
    </div>

    <?php if ($mensaje): ?>
        <div style="padding: 15px; border-radius: 6px; margin-bottom: 20px; background-color: <?php echo ($tipo_mensaje == 'success') ? '#DCFCE7' : '#FEE2E2'; ?>; color: <?php echo ($tipo_mensaje == 'success') ? '#166534' : '#991B1B'; ?>;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="card-box">
        <h3 style="margin-top:0; margin-bottom:20px;">Crear Nuevo Ticket</h3>
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Número de Cliente</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($num_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($nombre_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Correo Registrado</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($correo_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Teléfono Registrado</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($tel_fijo); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Categoría *</label>
                    <select name="categoria" class="form-control" required>
                        <option value="Falla Técnica">Falla Técnica</option>
                        <option value="Lentitud">Lentitud de servicio</option>
                        <option value="Facturación">Facturación</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Prioridad *</label>
                    <select name="prioridad" class="form-control" required>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Asunto *</label>
                    <input type="text" name="asunto" class="form-control" placeholder="Resumen del problema" required>
                </div>

                <div class="form-group full-width">
                    <label>Descripción Detallada *</label>
                    <textarea name="descripcion" class="form-control" rows="4" placeholder="Detalles del incidente..." required></textarea>
                </div>
            </div>
            <button type="submit" class="btn-dark" style="margin-top: 20px;">Crear Ticket</button>
        </form>
    </div>

    <div class="card-box">
        <h3 style="margin-top:0;">Mis Tickets</h3>
        <?php if ($res_tickets && $res_tickets->num_rows > 0): ?>
            <?php while($ticket = $res_tickets->fetch_assoc()): ?>
                <div class="ticket-item">
                    <div style="display:flex; justify-content:space-between;">
                        <strong>#<?php echo $ticket['id']; ?> - <?php echo htmlspecialchars($ticket['asunto']); ?></strong>
                        <span class="badge st-<?php echo str_replace(' ', '_', $ticket['estatus']); ?>"><?php echo $ticket['estatus']; ?></span>
                    </div>
                    <div style="font-size:0.85rem; color:#64748B; margin-top:5px;">
                        <?php echo date('d/m/Y H:i', strtotime($ticket['fecha_registro'])); ?> | Prioridad: <?php echo $ticket['prioridad']; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#64748B; text-align:center;">No tienes tickets registrados.</p>
        <?php endif; ?>
    </div>
</div>