<?php
// --- LÓGICA BACKEND ---

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_mensaje = "";

// 1. OBTENER DATOS DEL CLIENTE
$sql_cliente = "SELECT nombre, correo, telefono_1, numero, direccion FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$cliente = ($res_cliente && $res_cliente->num_rows > 0) ? $res_cliente->fetch_assoc() : [];

$nombre_fijo = $cliente['nombre'] ?? 'Usuario';
$correo_fijo = $cliente['correo'] ?? 'Sin correo';
$tel_fijo    = $cliente['telefono_1'] ?? 'Sin teléfono';
// ESTE ES EL DATO CLAVE PARA numero_solicitud
$num_fijo    = $cliente['numero'] ?? '000-000';
$dir_fija    = $cliente['direccion'] ?? 'Dirección no registrada';


// 2. PROCESAR CREACIÓN DE REPORTE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Datos del formulario
    $fk_etiqueta = (int)$_POST['categoria']; // ID de la etiqueta (1, 2, 3...)
    $prioridad = mb_strtoupper($conn->real_escape_string($_POST['prioridad']), 'UTF-8');
    $descripcion = mb_strtoupper($conn->real_escape_string($_POST['descripcion']), 'UTF-8');
    $asunto_web = mb_strtoupper($conn->real_escape_string($_POST['asunto']), 'UTF-8');

    // Mapeo de nombres para la nota (solo visual)
    $nombres_etiquetas = [
        1 => "SOPORTE S/C", 2 => "ANTENA S/C", 3 => "CAMBIO DOMICILIO",
        4 => "ANTENA C/C", 6 => "MIG. FIBRA S/C", 7 => "NVO. FIBRA S/C",
        8 => "BAJA SERVICIO", 9 => "SOPORTE C/C", 10 => "FIBRA C/C",
        11 => "MIG. FIBRA C/C"
    ];
    $nombre_servicio = $nombres_etiquetas[$fk_etiqueta] ?? "SOLICITUD WEB";

    if(!empty($descripcion)) {

        // --- 1. NUMERO DE SOLICITUD = NUMERO DE CLIENTE ---

        $num_solicitud = $num_fijo;

        // --- 2. NUMERO DE ORDEN VACÍO ---

        $num_orden = "";

        // Configuración
        $costo_servicio = 0.00;
        $estatus_inicial = "En proceso"; // Para que aparezca activo

        $anotaciones_final = "<br>\r\n" .
                             "+ SOLICITUD WEB: $nombre_servicio.<br>\r\n" .
                             "+ ASUNTO: $asunto_web.<br>\r\n" .
                             "+ DETALLE: $descripcion.<br>\r\n" .
                             "+ PRIORIDAD: $prioridad.<br>\r\n" .
                             "<br>";

        $sql_insert = "INSERT INTO ordenes
                       (numero_solicitud, numero_orden, fk_cliente, fk_etiqueta, costo_servicio, referencia, anotaciones, status, fecha_registro)
                       VALUES
                       ('$num_solicitud', '$num_orden', '$id_usuario', '$fk_etiqueta', '$costo_servicio', '$dir_fija', '$anotaciones_final', '$estatus_inicial', NOW())";

        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Solicitud enviada correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error técnico: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Por favor detalle su solicitud.";
        $tipo_mensaje = "error";
    }
}

// 3. CONSULTAR HISTORIAL
$sql_historial = "SELECT * FROM ordenes WHERE fk_cliente = '$id_usuario' ORDER BY fecha_registro DESC";
$res_ordenes = $conn->query($sql_historial);
?>

<style>
    .input-locked { background-color: #f1f5f9 !important; color: #64748B !important; cursor: not-allowed !important; border: 1px solid #e2e8f0; }
    .support-wrapper { max-width: 1000px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-control { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; }
    .btn-dark { background-color: #0F172A; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; }

    .ticket-item { border: 1px solid #f1f5f9; border-radius: 8px; padding: 15px; margin-bottom: 10px; }
    .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; }

    .st-Pendiente { background: #FEF9C3; color: #CA8A04; }
    .st-En_proceso { background: #DBEAFE; color: #2563EB; }
    .st-Aceptado { background: #DCFCE7; color: #16A34A; }
    .st-Cancelado { background: #F1F5F9; color: #64748B; }

    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>

<div class="support-wrapper">
    <div class="page-header">
        <h2>Atención a Clientes</h2>
        <p>Genere reportes o solicitudes de servicio</p>
    </div>

    <?php if ($mensaje): ?>
        <div style="padding: 15px; border-radius: 6px; margin-bottom: 20px; background-color: <?php echo ($tipo_mensaje == 'success') ? '#DCFCE7' : '#FEE2E2'; ?>; color: <?php echo ($tipo_mensaje == 'success') ? '#166534' : '#991B1B'; ?>;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="card-box">
        <h3 style="margin-top:0; margin-bottom:20px;">Nueva Solicitud</h3>
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Número de Cliente (Solicitud)</label>
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
                <div class="form-group full-width">
                    <label>Dirección del Servicio</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($dir_fija); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Tipo de Solicitud *</label>
                    <select name="categoria" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="1">NVO. SOPORTE S/C (Falla técnica, sin costo)</option>
                        <option value="9">NVO. SOPORTE C/C (Daño físico, con costo)</option>
                        <option value="3">CAM. DOMICILIO (Cambio de casa)</option>
                        <option value="8">BAJA DE SERVICIO</option>
                        <option value="2">NVO. ANTENA S/C</option>
                        <option value="4">NVO. ANTENA C/C</option>
                        <option value="7">NVO. FIBRA S/C</option>
                        <option value="10">NVO. FIBRA C/C</option>
                    </select>
                </div>
               

                <div class="form-group full-width">
                    <label>Asunto Breve *</label>
                    <input type="text" name="asunto" class="form-control" placeholder="Ej: NO TENGO INTERNET" required style="text-transform: uppercase;">
                </div>

                <div class="form-group full-width">
                    <label>Detalles de la Solicitud *</label>
                    <textarea name="descripcion" class="form-control" rows="4" placeholder="EXPLIQUE DETALLADAMENTE..." required style="text-transform: uppercase;"></textarea>
                </div>
            </div>
            <button type="submit" class="btn-dark" style="margin-top: 20px;">Enviar Solicitud</button>
        </form>
    </div>

    <div class="card-box">
        <h3 style="margin-top:0;">Historial de Solicitudes</h3>
        <?php if ($res_ordenes && $res_ordenes->num_rows > 0): ?>
            <?php while($orden = $res_ordenes->fetch_assoc()): ?>
                <?php
                    // Si tiene numero de orden asignado (ej: 2505-001) lo mostramos
                    // Si no, mostramos "Pendiente de Asignación"
                    $num_mostrar = !empty($orden['numero_orden']) ? strip_tags($orden['numero_orden']) : "Pendiente";

                    // Extraer ASUNTO de anotaciones para mostrar
                    $titulo_mostrar = "Solicitud Web";
                    if (strpos($orden['anotaciones'], 'ASUNTO:') !== false) {
                         preg_match('/ASUNTO: (.*?)(<br>|\.)/', $orden['anotaciones'], $matches);
                         if(isset($matches[1])) $titulo_mostrar = trim($matches[1]);
                    }
                ?>

                <div class="ticket-item">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <strong style="color:#1e293b; font-size:0.95rem;"><?php echo htmlspecialchars($titulo_mostrar); ?></strong>
                            <div style="font-size:0.85rem; color:#64748B; margin-top:5px;">
                                Orden: <strong><?php echo $num_mostrar; ?></strong> |
                                Fecha: <?php echo date('d/m/Y H:i', strtotime($orden['fecha_registro'])); ?>
                            </div>
                        </div>
                        <span class="badge st-<?php echo str_replace(' ', '_', $orden['status']); ?>"><?php echo $orden['status']; ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#64748B; text-align:center;">No hay solicitudes registradas.</p>
        <?php endif; ?>
    </div>
</div>