<?php
// --- LÓGICA BACKEND ---

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_mensaje = "";

// 1. OBTENER DATOS DEL CLIENTE (Para mostrar bloqueados)
$sql_cliente = "SELECT nombre, numero FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res_cliente = $conn->query($sql_cliente);
$cliente = ($res_cliente) ? $res_cliente->fetch_assoc() : [];

$nombre_fijo = $cliente['nombre'] ?? 'Usuario';
$numero_fijo = $cliente['numero'] ?? '---';


// 2. PROCESAR PAGO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $monto = $conn->real_escape_string($_POST['monto']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $metodo = $conn->real_escape_string($_POST['metodo']);
    $referencia = $conn->real_escape_string($_POST['referencia']);
    $banco = $conn->real_escape_string($_POST['banco']);
    $comentarios = $conn->real_escape_string($_POST['comentarios']);

    // Procesar archivo... (Lógica de subida de imagen)
    $ruta_final = "";
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] == 0) {
        $nombre_archivo = $id_usuario . "_" . time() . "_" . $_FILES['comprobante']['name'];
        $carpeta = "uploads/comprobantes/";
        if (!file_exists($carpeta)) mkdir($carpeta, 0777, true);
        
        if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $carpeta . $nombre_archivo)) {
            $ruta_final = $carpeta . $nombre_archivo;
        }
    }

    if (!empty($monto) && !empty($referencia)) {
        // Insertamos usando el ID de sesión (Seguridad)
        $sql_insert = "INSERT INTO pagos (fk_cliente, monto, fecha_pago, metodo_pago, referencia, banco_origen, comprobante_url, comentarios, status, fecha_registro) 
                       VALUES ('$id_usuario', '$monto', '$fecha', '$metodo', '$referencia', '$banco', '$ruta_final', '$comentarios', 'Pendiente', NOW())";

        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "✅ Pago reportado correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error al registrar: " . $conn->error;
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "El monto y la referencia son obligatorios.";
        $tipo_mensaje = "error";
    }
}
?>

<style>
    .input-locked { background-color: #f1f5f9; color: #64748B; cursor: not-allowed; border: 1px solid #e2e8f0; }
    .report-wrapper { max-width: 800px; margin: 0 auto; }
    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-top:20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-width { grid-column: span 2; }
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; }
    .form-control { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; box-sizing: border-box; }
    .btn-submit { background-color: #0F172A; color: white; border: none; padding: 12px; width:100%; border-radius: 6px; cursor: pointer; margin-top: 20px;}
</style>

<div class="report-wrapper">
    <h2>Reportar Pago</h2>
    
    <?php if ($mensaje): ?>
        <div style="padding:15px; margin-bottom:20px; background:<?php echo ($tipo_mensaje=='success')?'#DCFCE7':'#FEE2E2';?>; color:<?php echo ($tipo_mensaje=='success')?'#166534':'#991B1B';?>; border-radius:6px;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="card-box">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label>Cliente</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($nombre_fijo); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>No. Contrato</label>
                    <input type="text" class="form-control input-locked" value="<?php echo htmlspecialchars($numero_fijo); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Monto Pagado *</label>
                    <input type="number" name="monto" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Fecha Pago *</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Método *</label>
                    <select name="metodo" class="form-control" required>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Deposito">Depósito</option>
                        <option value="Sinpe">SINPE / Móvil</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Referencia / Comprobante *</label>
                    <input type="text" name="referencia" class="form-control" placeholder="Ej: 123456" required>
                </div>
                <div class="form-group full-width">
                    <label>Adjuntar Foto/PDF (Opcional)</label>
                    <input type="file" name="comprobante" class="form-control">
                </div>
                <div class="form-group full-width">
                    <label>Comentarios</label>
                    <textarea name="comentarios" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn-submit">Enviar Reporte</button>
        </form>
    </div>
</div>