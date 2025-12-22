<?php


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
$tab_actual = isset($_GET['tab']) ? $_GET['tab'] : 'perfil';

// 1. Obtener Datos del Cliente
// Nota: Usamos 'numero' para el campo Cédula/ID si no existe columna 'cedula'
$sql = "SELECT * FROM clientes WHERE id = '$id_usuario' LIMIT 1";
$res = $conn->query($sql);
$cliente = $res->fetch_assoc();

// 2. Lógica para Pestaña SERVICIO
$plan_nombre = "Sin Plan Activo";
$plan_velocidad = "0 Mbps";
$plan_precio = "0.00";
$estatus_servicio = "Inactivo";
$fecha_instalacion = "---";

$sql_orden = "SELECT * FROM ordenes WHERE fk_cliente = '$id_usuario' ORDER BY id DESC LIMIT 1";
$res_ord = $conn->query($sql_orden);

if($res_ord && $res_ord->num_rows > 0){
    $orden = $res_ord->fetch_assoc();
    $estatus_servicio = $orden['status'];
    $raw_nota = $orden['anotaciones'];
    if(strpos($raw_nota, 'Plan Solicitado:') !== false) {
        $parts = explode(":", $raw_nota);
        $subparts = explode("\n", $parts[1]);
        $plan_nombre = trim($subparts[0]);
    } else {
        $plan_nombre = "Plan Personalizado";
    }
    $plan_velocidad = (strpos($plan_nombre, 'Básico') !== false) ? '10 Mbps' : ((strpos($plan_nombre, 'Hogar') !== false) ? '30 Mbps' : '100 Mbps');
    $plan_precio = (strpos($plan_nombre, 'Básico') !== false) ? '25.00' : ((strpos($plan_nombre, 'Hogar') !== false) ? '45.00' : '75.00');
    $fecha_instalacion = date('d/m/Y', strtotime($orden['fecha_registro']));
}

// Historial de Pagos
$sql_pagos = "SELECT * FROM pagos WHERE fk_cliente = '$id_usuario' ORDER BY fecha_pago DESC LIMIT 5";
$res_pagos = $conn->query($sql_pagos);

// 3. Lógica Seguridad
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_pass') {
    $pass_nueva = $_POST['new_password'];
    $pass_conf = $_POST['confirm_password'];
    if ($pass_nueva === $pass_conf) {
        $mensaje = "✅ Contraseña actualizada correctamente.";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Las contraseñas no coinciden.";
        $tipo_mensaje = "error";
    }
}
?>

<style>
    .profile-wrapper { max-width: 900px; margin: 0 auto; }
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .page-header p { margin: 0; color: #64748B; font-size: 0.95rem; }

    /* Tabs */
    .tabs-nav {
        display: flex; gap: 5px; margin-bottom: 25px;
        background: #F1F5F9; padding: 5px; border-radius: 10px;
        width: fit-content; flex-wrap: wrap;
    }
    .tab-link {
        padding: 8px 20px; border-radius: 8px; font-size: 0.9rem; font-weight: 500;
        text-decoration: none; color: #64748B; transition: all 0.2s;
    }
    .tab-link:hover { color: #333; background: rgba(255,255,255,0.6); }
    .tab-link.active { background: white; color: #0F172A; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }

    /* Content Card General */
    .content-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* --- ESTILOS DE PERFIL (Réplica exacta) --- */
    .profile-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 30px; 
    }
    .user-ident { display: flex; gap: 20px; align-items: center; }
    
    .avatar-circle {
        width: 78px; height: 78px; min-width: 78px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; font-weight: 700;
        box-shadow: 0 12px 25px rgba(37, 99, 235, 0.25);
        overflow: hidden;
    }
    .avatar-circle img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }
    
    .user-text h3 { margin: 0 0 5px 0; font-size: 1.1rem; color: #1e293b; font-weight: 600; }
    .user-text span { font-size: 0.9rem; color: #64748B; }

    .btn-edit-outline {
        border: 1px solid #E2E8F0; background: white; color: #334155;
        padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;
        text-decoration: none; transition: background 0.2s;
    }
    .btn-edit-outline:hover { background: #F8FAFC; border-color: #CBD5E1; }

    /* Grid de Datos */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
    .full-width { grid-column: span 2; }
    
    .info-group label {
        display: block; font-size: 0.85rem; font-weight: 600; color: #1e293b;
        margin-bottom: 8px;
    }
    
    /* Simulación de Input Readonly */
    .info-display {
        background-color: #F8FAFC; 
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 12px 15px;
        font-size: 0.95rem;
        color: #475569; 
        width: 100%;
        box-sizing: border-box;
    }

    /* --- ESTILOS PLAN --- */
    .plan-detail-card {
        background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%);
        color: white; border-radius: 16px; padding: 28px 32px;
        display: flex; justify-content: space-between; align-items: center; gap: 20px;
        margin-bottom: 30px; position: relative; overflow: hidden;
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.35);
    }
    .plan-info h4 { margin: 0; font-size: 0.9rem; color: #94A3B8; letter-spacing: 1px; }
    .plan-info h2 { margin: 5px 0 10px 0; font-size: 1.8rem; }
    .plan-meta { display: flex; gap: 18px; font-size: 0.95rem; color: #CBD5E1; }
    .plan-status { text-align: right; }
    .status-pill { padding: 6px 14px; border-radius: 999px; font-size: 0.85rem; background: rgba(16, 185, 129, 0.2); color: #34D399; display: inline-flex; align-items: center; }
    .plan-price { font-size: 1.6rem; font-weight: 600; }

    /* Tabla */
    .styled-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
    .styled-table th { text-align: left; padding: 12px; color: #64748B; border-bottom: 2px solid #F1F5F9; }
    .styled-table td { padding: 12px; border-bottom: 1px solid #F1F5F9; color: #334155; }
    .pay-badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
    .pay-Verificado { background: #DCFCE7; color: #166534; }
    .pay-Pendiente { background: #FFF7ED; color: #C2410C; }

    /* Otros inputs (Seguridad) */
    .form-control { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; }
    .btn-save { background: #0F172A; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; margin-top: 15px; }
    .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; }
    .alert-success { background: #DCFCE7; color: #166534; } .alert-error { background: #FEE2E2; color: #991B1B; }

    @media(max-width: 900px) {
        .profile-wrapper { padding: 0 15px; }
        .plan-detail-card { flex-direction: column; align-items: flex-start; gap: 18px; }
    }
    @media(max-width: 600px) {
        .info-grid { grid-template-columns: 1fr; }
        .full-width { grid-column: span 1; }
        .profile-header { flex-direction: column; align-items: flex-start; }
        .plan-meta { flex-direction: column; align-items: flex-start; gap: 10px; font-size: 1rem; }
        .plan-detail-card {
            padding: 26px 22px 32px;
            border-radius: 20px;
            gap: 16px;
            align-items: flex-start;
            text-align: left;
        }
        .plan-status {
            width: 100%;
            text-align: left;
        }
        .plan-info h2 { font-size: 1.65rem; }
        .plan-price { font-size: 1.9rem; }
        .status-pill { font-size: 0.95rem; padding: 8px 18px; }
        .table-container { overflow-x: auto; }
    }
</style>

<div class="profile-wrapper view-shell">

    <div class="page-header">
        <h2>Mi Información</h2>
        <p>Gestiona tu perfil y configuración de cuenta</p>
    </div>

    <div class="tabs-nav">
        <a href="?vista=mi_informacion&tab=perfil" class="tab-link <?php echo $tab_actual == 'perfil' ? 'active' : ''; ?>">Perfil</a>
        <a href="?vista=mi_informacion&tab=servicio" class="tab-link <?php echo $tab_actual == 'servicio' ? 'active' : ''; ?>">Mi Servicio</a>
        <a href="?vista=mi_informacion&tab=seguridad" class="tab-link <?php echo $tab_actual == 'seguridad' ? 'active' : ''; ?>">Seguridad</a>
        <a href="?vista=mi_informacion&tab=notificaciones" class="tab-link <?php echo $tab_actual == 'notificaciones' ? 'active' : ''; ?>">Notificaciones</a>
    </div>

    <div class="content-card">
        
        <?php if($tab_actual == 'perfil'): ?>
            <div class="profile-header">
                <div class="user-ident">
                    <div class="avatar-circle">
                        <?php 
                            // Lógica de Avatar Inteligente
                            $nombre_completo = isset($cliente['nombre']) ? $cliente['nombre'] : 'U';
                            if (preg_match('/[a-zA-ZñÑáéíóúÁÉÍÓÚ]/u', $nombre_completo, $coincidencias)) {
                                $inicial = $coincidencias[0]; 
                            } else {
                                $inicial = substr($nombre_completo, 0, 1);
                            }
                            echo strtoupper($inicial); 
                        ?>
                    </div>
                    <div class="user-text">
                        <h3><?php echo htmlspecialchars($cliente['nombre']); ?></h3>
                        <span>Cliente desde: <?php echo isset($cliente['fecha_registro']) ? date('F Y', strtotime($cliente['fecha_registro'])) : 'Enero 2023'; ?></span>
                    </div>
                </div>
                <a href="#" class="btn-edit-outline">Editar</a>
            </div>

            <h4 style="margin: 0 0 20px 0; color: #333; font-weight: 500;">Información Personal</h4>

            <div class="info-grid">
                <div class="info-group">
                    <label>Nombre Completo *</label>
                    <div class="info-display"><?php echo htmlspecialchars($cliente['nombre']); ?></div>
                </div>
                <div class="info-group">
                    <label>Cédula</label>
                    <div class="info-display"><?php echo htmlspecialchars($cliente['numero'] ?? '---'); ?></div>
                </div>

                <div class="info-group">
                    <label>Correo Electrónico *</label>
                    <div class="info-display">
                        <?php echo !empty($cliente['email']) ? htmlspecialchars($cliente['email']) : 'No registrado'; ?>
                    </div>
                </div>
                <div class="info-group">
                    <label>Teléfono *</label>
                    <div class="info-display"><?php echo htmlspecialchars($cliente['telefono_1']); ?></div>
                </div>

                <div class="info-group full-width">
                    <label>Dirección de Servicio</label>
                    <div class="info-display"><?php echo htmlspecialchars($cliente['direccion']); ?></div>
                </div>
            </div>

        <?php elseif($tab_actual == 'servicio'): ?>
            <h3 style="margin-top:0; margin-bottom:15px; color:#333;">Plan Contratado</h3>
            <div class="plan-detail-card">
                <div class="plan-info">
                    <h4>Paquete Actual</h4>
                    <h2><?php echo htmlspecialchars($plan_nombre); ?></h2>
                    <div class="plan-meta">
                        <span><i class="fa-solid fa-gauge-high"></i> <?php echo $plan_velocidad; ?></span>
                        <span><i class="fa-regular fa-calendar-check"></i> Instalado: <?php echo $fecha_instalacion; ?></span>
                    </div>
                </div>
                <div class="plan-status">
                    <span class="status-pill"><?php echo $estatus_servicio; ?></span>
                    <div class="plan-price" style="margin-top:10px;">$<?php echo $plan_precio; ?> <small>/mes</small></div>
                </div>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                <h3 style="margin:0; color:#333;">Historial de Pagos</h3>
                <a href="?vista=reportar_pago" style="font-size:0.85rem; color:#2563EB; font-weight:600; text-decoration:none;">Reportar Nuevo Pago &rarr;</a>
            </div>

            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr><th>Fecha</th><th>Monto</th><th>Método</th><th>Referencia</th><th>Estatus</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($res_pagos && $res_pagos->num_rows > 0): ?>
                            <?php while($pago = $res_pagos->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($pago['fecha_pago'])); ?></td>
                                    <td>$<?php echo number_format($pago['monto'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($pago['metodo_pago']); ?></td>
                                    <td style="color:#64748B;"><?php echo htmlspecialchars($pago['referencia']); ?></td>
                                    <td><span class="pay-badge pay-<?php echo $pago['status']; ?>"><?php echo $pago['status']; ?></span></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center; color:#94A3B8; padding:20px;">No hay pagos registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($tab_actual == 'seguridad'): ?>
            <h3 style="margin-top:0;">Cambiar Contraseña</h3>
            <?php if ($mensaje): ?><div class="alert <?php echo ($tipo_mensaje == 'success') ? 'alert-success' : 'alert-error'; ?>"><?php echo $mensaje; ?></div><?php endif; ?>
            <form action="" method="POST">
                <input type="hidden" name="action" value="update_pass">
                <div class="info-grid">
                    <div class="info-group full-width">
                        <label>Nueva Contraseña</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="info-group full-width">
                        <label>Confirmar Contraseña</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn-save">Actualizar</button>
            </form>

        <?php elseif($tab_actual == 'notificaciones'): ?>
            <h3 style="margin-top:0;">Preferencias</h3>
            <p style="color:#64748B;">Configura cómo quieres recibir nuestras alertas.</p>
        <?php endif; ?>

    </div>
</div>
