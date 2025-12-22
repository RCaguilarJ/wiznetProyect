<?php
// --- LÓGICA BACKEND ---

if (!isset($conn)) {
    if (file_exists("includes/conexion.php")) require_once "includes/conexion.php";
    elseif (file_exists("../includes/conexion.php")) require_once "../includes/conexion.php";
}

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_mensaje = "";

// 1. Obtener datos del cliente (CORREGIDO: tabla clientes, columna correo)
$sql_cliente = "SELECT nombre, correo, telefono_1, numero FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$cliente = ($res_cliente && $res_cliente->num_rows > 0) ? $res_cliente->fetch_assoc() : [];

// Mapeo seguro
$nombre_form = $cliente['nombre'] ?? '';
$correo_form = $cliente['correo'] ?? ''; // Usamos 'correo'
$tel_form = $cliente['telefono_1'] ?? '';
$num_form = $cliente['numero'] ?? '';


// 2. PROCESAR CREACIÓN DE TICKET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $prioridad = $conn->real_escape_string($_POST['prioridad']);
    $asunto = $conn->real_escape_string($_POST['asunto']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);

    if(!empty($asunto) && !empty($descripcion)) {
        $sql_insert = "INSERT INTO tickets (fk_cliente, categoria, prioridad, asunto, descripcion, estatus) 
                       VALUES ('$id_usuario', '$categoria', '$prioridad', '$asunto', '$descripcion', 'Pendiente')";
        
        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Ticket #".$conn->insert_id." creado exitosamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error al crear ticket: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Por favor llene todos los campos obligatorios.";
        $tipo_mensaje = "error";
    }
}

// 3. CONSULTAR HISTORIAL
$sql_historial = "SELECT * FROM tickets WHERE fk_cliente = '$id_usuario' ORDER BY fecha_registro DESC";
$res_tickets = $conn->query($sql_historial);
?>

<style>
    .support-wrapper { max-width: 1000px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .page-header p { margin: 0; color: #64748B; font-size: 0.95rem; }

    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
    .card-title { font-size: 1rem; font-weight: 600; color: #333; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    
    .form-group { display: flex; flex-direction: column; margin-bottom: 5px;}
    .form-group label { font-size: 0.8rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-control { background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 10px 12px; font-size: 0.9rem; color: #334155; width: 100%; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #3B82F6; background-color: white; }
    
    .btn-row { display: flex; gap: 15px; margin-top: 15px; }
    .btn-dark { background-color: #0F172A; color: white; border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; cursor: pointer; flex: 1; }
    .btn-light { background-color: white; border: 1px solid #e2e8f0; color: #333; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; }

    .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid transparent; }
    .alert-success { background-color: #DCFCE7; color: #166534; border-color: #BBF7D0; }
    .alert-error { background-color: #FEE2E2; color: #991B1B; border-color: #FECACA; }

    .bottom-section { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    @media (max-width: 768px) { .bottom-section { grid-template-columns: 1fr; } }

    .ticket-item { border: 1px solid #f1f5f9; border-radius: 8px; padding: 15px; margin-bottom: 15px; background-color: white; transition: background 0.2s; }
    .ticket-item:hover { background-color: #F8FAFC; }
    .ticket-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
    .ticket-id { font-size: 0.85rem; color: #2563EB; font-weight: 600; }
    .ticket-title { font-weight: 500; color: #1e293b; font-size: 0.95rem; margin-bottom: 10px; display: block; }
    .ticket-footer { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #94A3B8; }

    .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; }
    .prio-Alta { background-color: #FEE2E2; color: #DC2626; }
    .prio-Media { background-color: #FFEDD5; color: #EA580C; }
    .prio-Baja { background-color: #F1F5F9; color: #64748B; }
    
    .st-Pendiente { background-color: #FEF9C3; color: #CA8A04; }
    .st-En_Progreso { background-color: #DBEAFE; color: #2563EB; }
    .st-Resuelto { background-color: #DCFCE7; color: #16A34A; }
    .st-Cerrado { background-color: #F1F5F9; color: #475569; }
</style>

<div class="support-wrapper">
    <div class="page-header">
        <h2>Soporte Técnico</h2>
        <p>Cree un ticket de soporte o consulte sus tickets existentes</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert <?php echo ($tipo_mensaje == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="card-box">
        <h3 class="card-title">Crear Nuevo Ticket</h3>
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Número de Cliente</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($num_form); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($nombre_form); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>
                
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($correo_form); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>
                
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($tel_form); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Categoría *</label>
                    <select name="categoria" class="form-control" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Falla Técnica">Falla Técnica</option>
                        <option value="Lentitud">Lentitud de servicio</option>
                        <option value="Facturación">Facturación</option>
                        <option value="Cambio de Plan">Cambio de Plan</option>
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
                    <input type="text" name="asunto" class="form-control" placeholder="Breve descripción del problema" required>
                </div>

                <div class="form-group full-width">
                    <label>Descripción Detallada *</label>
                    <textarea name="descripcion" class="form-control" rows="3" placeholder="Describa su problema o consulta" required></textarea>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-dark">Crear Ticket</button>
                <button type="reset" class="btn-light">Limpiar</button>
            </div>
        </form>
    </div>

    <div class="bottom-section">
        <div class="card-box" style="margin-bottom: 0;">
            <h3 class="card-title">Mis Tickets Recientes</h3>
            <?php if ($res_tickets && $res_tickets->num_rows > 0): ?>
                <?php while($ticket = $res_tickets->fetch_assoc()): ?>
                    <?php
                        $class_prio = 'prio-' . $ticket['prioridad'];
                        $class_status = 'st-' . str_replace(' ', '_', $ticket['estatus']);
                    ?>
                    <div class="ticket-item">
                        <div class="ticket-header">
                            <span class="ticket-id">#<?php echo $ticket['id']; ?></span>
                            <span class="badge <?php echo $class_prio; ?>"><?php echo $ticket['prioridad']; ?></span>
                        </div>
                        <span class="ticket-title"><?php echo htmlspecialchars($ticket['asunto']); ?></span>
                        <div class="ticket-footer">
                            <span class="badge <?php echo $class_status; ?>"><?php echo $ticket['estatus']; ?></span>
                            <span><?php echo date('d/m/Y', strtotime($ticket['fecha_registro'])); ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="text-align:center; padding: 20px; color:#94A3B8;">
                    <p>No tienes tickets registrados.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-box" style="margin-bottom: 0;">
            <h3 class="card-title">Información de Contacto</h3>
            <div style="font-size:0.9rem; color:#475569;">
                <p><strong>Teléfono:</strong> 2222-2222</p>
                <p><strong>Email:</strong> soporte@wiznet.com</p>
                <p><strong>Horario:</strong> 24/7</p>
            </div>
        </div>
    </div>
</div>