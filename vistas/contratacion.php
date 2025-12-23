<?php
// --- LÓGICA BACKEND ---

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_mensaje = "";

// 1. OBTENER DATOS (Bloqueados)
$sql_cliente = "SELECT nombre, correo, telefono_1 FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$cliente = ($res_cliente) ? $res_cliente->fetch_assoc() : [];

$nombre_fijo = $cliente['nombre'] ?? '';
$correo_fijo = $cliente['correo'] ?? '';
$tel_fijo    = $cliente['telefono_1'] ?? '';

// Preselección de plan desde URL
$pre_plan = isset($_GET['plan']) ? $_GET['plan'] : '';


// 2. PROCESAR SOLICITUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $plan = $conn->real_escape_string($_POST['plan_interes']);
    $comentarios = $conn->real_escape_string($_POST['comentarios']);
    
    // Generamos folios
    $num_solicitud = "SOL-" . date('ymd') . "-" . rand(100, 999);
    
    // Nota interna con los datos fijos
    $nota_completa = "Plan Solicitado: $plan. \nContacto: $correo_fijo | $tel_fijo. \nNota: $comentarios";

    if (!empty($direccion) && !empty($plan)) {
        $sql_insert = "INSERT INTO ordenes (numero_solicitud, fk_cliente, referencia, anotaciones, status, fecha_registro) 
                       VALUES ('$num_solicitud', '$id_usuario', '$direccion', '$nota_completa', 'En proceso', NOW())";

        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Solicitud enviada correctamente (Folio: $num_solicitud).";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error al enviar: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Complete la dirección y el plan.";
        $tipo_mensaje = "error";
    }
}
?>

<style>
    .input-locked { background-color: #f1f5f9; color: #64748B; cursor: not-allowed; border: 1px solid #e2e8f0; }
    .form-wrapper { max-width: 800px; margin: 0 auto; }
    .form-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-top:20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; }
    .form-control { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; }
    .btn-submit { background-color: #0F172A; color: white; border: none; padding: 12px; width:100%; border-radius: 6px; cursor: pointer; margin-top: 20px;}
</style>

<div class="form-wrapper">
    <h2>Solicitar Nuevo Servicio</h2>

    <?php if ($mensaje): ?>
        <div style="padding:15px; margin-bottom:20px; background:<?php echo ($tipo_mensaje=='success')?'#DCFCE7':'#FEE2E2';?>; color:<?php echo ($tipo_mensaje=='success')?'#166534':'#991B1B';?>; border-radius:6px;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Nombre del Titular</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($nombre_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Correo de Contacto</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($correo_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Teléfono de Contacto</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($tel_fijo); ?>" readonly>
                </div>

                <div class="form-group full-width">
                    <label>Dirección de Instalación *</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Provincia, Cantón, Distrito y señas exactas" required>
                </div>

                <div class="form-group full-width">
                    <label>Plan de Interés *</label>
                    <select name="plan_interes" id="planInteres" class="form-select" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <optgroup label="Residencial">
                            <option value="Paq. Básico Residencial - 5 MB ($300)">Paq. Básico Residencial - 5 MB ($300)</option>
                            <option value="Paq. Medio Residencial - 7 MB ($400)">Paq. Medio Residencial - 7 MB ($400)</option>
                            <option value="Paq. Alto Residencial - 10 MB ($550)">Paq. Alto Residencial - 10 MB ($550)</option>
                        </optgroup>
                        <optgroup label="Comercial">
                            <option value="Negocio Básico">Negocio Básico</option>
                            <option value="Negocio Plus">Negocio Plus</option>
                            <option value="Empresarial">Empresarial</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Comentarios Adicionales</label>
                    <textarea name="comentarios" class="form-control" placeholder="Horario preferido, referencias, etc."></textarea>
                </div>
            </div>
            <button type="submit" class="btn-submit">Enviar Solicitud</button>
        </form>
    </div>
</div>

<script>
    // Script simple para preseleccionar plan si viene de URL
    window.addEventListener('DOMContentLoaded', () => {
        const planPre = "<?php echo $pre_plan; ?>";
        if(planPre) {
            const select = document.getElementById('planInteres');
            // Mapeo simple de URL a valor del select
            let valorBuscar = "";
            if(planPre.includes("basico")) valorBuscar = "Básico";
            if(planPre.includes("medio")) valorBuscar = "Medio";
            if(planPre.includes("alto")) valorBuscar = "Alto";
            
            if(valorBuscar) {
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value.includes(valorBuscar)) {
                        select.selectedIndex = i; break;
                    }
                }
            }
        }
    });
</script>