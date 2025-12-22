<?php

// 1. Conexión y Sesión
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

// 2. Obtener datos del cliente (CORREGIDO: Sin pedir email)
$sql_cliente = "SELECT nombre, telefono_1 FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res = $conn->query($sql_cliente);

$cliente = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : ['nombre'=>'', 'telefono_1'=>''];


$pre_tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$pre_plan = isset($_GET['plan']) ? $_GET['plan'] : '';


// 3. PROCESAR EL FORMULARIO (GUARDAR ORDEN)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $plan_seleccionado = $conn->real_escape_string($_POST['plan_interes']);
    $tipo_plan = $conn->real_escape_string($_POST['tipo_plan']);
    $comentarios_user = $conn->real_escape_string($_POST['comentarios']);
    
    // Recibir correo 
    $correo_contacto = $conn->real_escape_string($_POST['correo']); 

    // Validar campos obligatorios
    if (!empty($direccion) && !empty($plan_seleccionado)) {
        
        // Generar folios automáticos
        $num_solicitud = "SOL-" . date('ymd') . "-" . rand(100, 999);
        $num_orden = "ORD-" . rand(10000, 99999);
        
        // Combinar Plan + Comentarios + Correo de contacto en el campo 'anotaciones'
        $anotaciones_final = "Plan Solicitado: " . $plan_seleccionado . " (" . ucfirst($tipo_plan) . ").\n" . 
                             "Correo de contacto: " . $correo_contacto . ".\n" .
                             "Nota del cliente: " . $comentarios_user;
        
       
        // Mapeo: referencia = dirección, anotaciones = plan+notas, status = En proceso
        $sql_insert = "INSERT INTO ordenes (numero_solicitud, numero_orden, fk_cliente, referencia, anotaciones, status, fecha_registro) 
                       VALUES ('$num_solicitud', '$num_orden', '$id_usuario', '$direccion', '$anotaciones_final', 'En proceso', NOW())";

        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "¡Solicitud enviada! Tu número de gestión es <strong>$num_solicitud</strong>.";
            $tipo_mensaje = "success";
            // Limpiar campos visualmente
            $pre_plan = ""; 
            $pre_tipo = "";
        } else {
            $mensaje = "Error al guardar la orden: " . $conn->error;
            $tipo_mensaje = "error";
        }

    } else {
        $mensaje = "Por favor completa la dirección y selecciona un plan.";
        $tipo_mensaje = "error";
    }
}
?>

<style>
    /* Estilos Base */
    .form-wrapper { max-width: 800px; margin: 0 auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .page-header p { margin: 0; color: #64748B; }
    
    /* Tarjeta */
    .form-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .form-section-title { font-size: 1rem; color: #333; margin-bottom: 25px; font-weight: 500; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    
    /* Grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .full-width { grid-column: span 2; }
    @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }

    /* Inputs */
    .form-group { display: flex; flex-direction: column; }
    .form-group label { font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-input, .form-select, .form-textarea { 
        background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 12px; 
        font-family: inherit; font-size: 0.95rem; color: #334155; transition: border-color 0.2s; width: 100%; box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #3B82F6; background-color: white; }
    
    /* Estilo especial para campos de solo lectura */
    .form-input[readonly] { background-color: #f1f5f9; color: #64748B; cursor: not-allowed; }
    
    /* Botones */
    .form-actions { display: flex; gap: 15px; margin-top: 20px; }
    .btn-submit { background-color: #0F172A; color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 600; cursor: pointer; flex: 1; }
    .btn-submit:hover { background-color: #1e293b; }
    .btn-clear { background-color: white; color: #1e293b; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; }
    .btn-clear:hover { background-color: #f1f5f9; }
    
    /* Alertas */
    .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.95rem; border: 1px solid transparent; }
    .alert-success { background-color: #DCFCE7; color: #166534; border-color: #BBF7D0; }
    .alert-error { background-color: #FEE2E2; color: #991B1B; border-color: #FECACA; }
    
    .form-footer-text { font-size: 0.75rem; color: #64748B; margin-top: 20px; }

    @media (max-width: 900px) {
        .form-wrapper { padding: 0 15px; }
        .form-card { padding: 25px; }
    }
    @media (max-width: 600px) {
        .form-card { padding: 20px; }
        .form-actions { flex-direction: column; }
        .btn-submit, .btn-clear { width: 100%; }
    }
</style>

<div class="form-wrapper view-shell">
    
    <div class="page-header">
        <h2>Formulario de Contratación</h2>
        <p>Complete el formulario y nos contactaremos con usted para la instalación.</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert <?php echo ($tipo_mensaje == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <h3 class="form-section-title">Información del Cliente</h3>

        <form action="" method="POST">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico *</label>
                    <input type="email" name="correo" class="form-input" placeholder="juan@ejemplo.com" required>
                </div>

                <div class="form-group">
                    <label>Teléfono de Contacto</label>
                    <input type="tel" class="form-input" value="<?php echo htmlspecialchars($cliente['telefono_1']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Tipo de Plan *</label>
                    <select name="tipo_plan" id="tipoPlan" class="form-select" onchange="filtrarPlanes()" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="residencial" <?php echo ($pre_tipo == 'residencial') ? 'selected' : ''; ?>>Residencial</option>
                        <option value="comercial" <?php echo ($pre_tipo == 'comercial') ? 'selected' : ''; ?>>Comercial</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Dirección de Instalación *</label>
                    <input type="text" name="direccion" class="form-input" placeholder="Provincia, Cantón, Distrito y señas exactas" required>
                </div>

                <div class="form-group full-width">
                    <label>Plan de Interés *</label>
                    <select name="plan_interes" id="planInteres" class="form-select" required>
                        <option value="">Seleccione un plan</option>
                        
                        <optgroup label="Residencial" class="grupo-residencial">
                            <option value="Plan Básico - 10 Mbps">Plan Básico - 10 Mbps</option>
                            <option value="Plan Hogar - 30 Mbps">Plan Hogar - 30 Mbps</option>
                            <option value="Plan Premium - 100 Mbps">Plan Premium - 100 Mbps</option>
                        </optgroup>

                        <optgroup label="Comercial" class="grupo-comercial">
                            <option value="Negocio Básico - 50 Mbps">Negocio Básico - 50 Mbps</option>
                            <option value="Negocio Plus - 200 Mbps">Negocio Plus - 200 Mbps</option>
                            <option value="Empresarial - 500 Mbps">Empresarial - 500 Mbps</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Comentarios Adicionales</label>
                    <textarea name="comentarios" class="form-textarea" placeholder="Indique cualquier información adicional (ej: horario preferido)"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enviar Solicitud</button>
                <button type="reset" class="btn-clear" onclick="resetFilters()">Limpiar</button>
            </div>

            <p class="form-footer-text">* Campos requeridos. Sus datos serán tratados con confidencialidad.</p>

        </form>
    </div>
</div>

<script>
    function filtrarPlanes() {
        const tipo = document.getElementById('tipoPlan').value;
        const selectPlanes = document.getElementById('planInteres');
        
        const grupoResidencial = document.querySelector('.grupo-residencial');
        const grupoComercial = document.querySelector('.grupo-comercial');

        if (tipo === "") {
            grupoResidencial.style.display = '';
            grupoComercial.style.display = '';
        } else if (tipo === 'residencial') {
            grupoResidencial.style.display = '';
            grupoComercial.style.display = 'none';
        } else if (tipo === 'comercial') {
            grupoResidencial.style.display = 'none';
            grupoComercial.style.display = '';
        }
    }

    function resetFilters() {
        setTimeout(filtrarPlanes, 100);
    }

    window.addEventListener('DOMContentLoaded', () => {
        filtrarPlanes();
        const planPre = "<?php echo $pre_plan; ?>";
        if(planPre) {
            const select = document.getElementById('planInteres');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value.toLowerCase().includes(planPre.toLowerCase())) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    });
</script>
