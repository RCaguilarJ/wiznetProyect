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

// 1. Obtener datos del cliente (CORREGIDO: tabla clientes)
$sql_cliente = "SELECT nombre, numero FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$datos_cliente = ($res_cliente && $res_cliente->num_rows > 0) ? $res_cliente->fetch_assoc() : ['nombre'=>'Usuario', 'numero'=>'---'];


// 2. PROCESAR EL FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $monto = $conn->real_escape_string($_POST['monto']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $metodo = $conn->real_escape_string($_POST['metodo']);
    $referencia = $conn->real_escape_string($_POST['referencia']);
    $banco = $conn->real_escape_string($_POST['banco']);
    $comentarios = $conn->real_escape_string($_POST['comentarios']);

    $ruta_final = "";
    
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] == 0) {
        $nombre_archivo = $_FILES['comprobante']['name'];
        $tipo_archivo = $_FILES['comprobante']['type'];
        $tmp_name = $_FILES['comprobante']['tmp_name'];
        
        $permitidos = array("image/jpg", "image/jpeg", "image/png", "application/pdf");
        
        if (in_array($tipo_archivo, $permitidos)) {
            $nombre_nuevo = $id_usuario . "_" . time() . "_" . $nombre_archivo;
            $carpeta_destino = "uploads/comprobantes/";
            if (!file_exists($carpeta_destino)) { mkdir($carpeta_destino, 0777, true); }
            
            $ruta_final = $carpeta_destino . $nombre_nuevo;

            if (move_uploaded_file($tmp_name, $ruta_final)) {
                // Éxito al subir
            } else {
                $mensaje = "Error al subir el archivo al servidor.";
                $tipo_mensaje = "error";
            }
        } else {
            $mensaje = "Formato no permitido. Use JPG, PNG o PDF.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Es obligatorio adjuntar el comprobante.";
        $tipo_mensaje = "error";
    }

    if (empty($mensaje)) {
        $sql_insert = "INSERT INTO pagos (fk_cliente, monto, fecha_pago, metodo_pago, referencia, banco_origen, comprobante_url, comentarios, status) 
                       VALUES ('$id_usuario', '$monto', '$fecha', '$metodo', '$referencia', '$banco', '$ruta_final', '$comentarios', 'Pendiente')";

        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Reporte enviado correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error DB: " . $conn->error;
            $tipo_mensaje = "error";
        }
    }
}
?>

<style>
    .report-wrapper { max-width: 800px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group { display: flex; flex-direction: column; margin-bottom:15px; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    .form-control { background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 10px; width: 100%; box-sizing: border-box; }
    .btn-submit { background-color: #0F172A; color: white; border: none; border-radius: 6px; padding: 12px; width:100%; cursor: pointer; }
    .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; }
    .alert-success { background-color: #DCFCE7; color: #166534; } .alert-error { background-color: #FEE2E2; color: #991B1B; }
    .file-upload-area { border: 2px dashed #CBD5E1; padding: 20px; text-align: center; cursor: pointer; background: #F8FAFC; border-radius: 8px; }
    @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>

<div class="report-wrapper">
    <div class="page-header">
        <h2>Reportar Pago</h2>
        <p>Complete el formulario para reportar su pago</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert <?php echo ($tipo_mensaje == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="card-box">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                
                <div class="form-group">
                    <label>Número de Cliente</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos_cliente['numero']); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Nombre del Cliente</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos_cliente['nombre']); ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Monto Pagado *</label>
                    <input type="number" name="monto" step="0.01" class="form-control" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Fecha del Pago *</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Método de Pago *</label>
                    <select name="metodo" class="form-control" required>
                        <option value="">Seleccione un método</option>
                        <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                        <option value="Deposito">Depósito en Ventanilla</option>
                        <option value="SINPE">SINPE Móvil</option>
                        <option value="Tarjeta">Tarjeta / Online</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Número de Referencia *</label>
                    <input type="text" name="referencia" class="form-control" placeholder="Ej: 123456789" required>
                </div>

                <div class="form-group full-width">
                    <label>Banco de Origen</label>
                    <input type="text" name="banco" class="form-control" placeholder="Nombre del banco (Opcional)">
                </div>

                <div class="form-group full-width">
                    <label>Comprobante de Pago *</label>
                    <div class="file-upload-area" onclick="document.getElementById('comprobante').click()">
                        <input type="file" name="comprobante" id="comprobante" accept=".jpg,.jpeg,.png,.pdf" style="display:none;" required>
                        <span id="file-text">Haga clic para seleccionar archivo (JPG, PNG, PDF)</span>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Comentarios</label>
                    <textarea name="comentarios" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn-submit" style="margin-top:20px;">Enviar Reporte</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('comprobante').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            document.getElementById('file-text').textContent = 'Archivo seleccionado: ' + this.files[0].name;
            document.querySelector('.file-upload-area').style.borderColor = '#2563EB';
            document.querySelector('.file-upload-area').style.backgroundColor = '#EFF6FF';
        }
    });
</script>