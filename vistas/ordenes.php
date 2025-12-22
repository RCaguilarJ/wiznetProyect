<?php


// 1. Conexión
if (!isset($conn)) {
    if (file_exists("includes/conexion.php")) require_once "includes/conexion.php";
    elseif (file_exists("../includes/conexion.php")) require_once "../includes/conexion.php";
}

// 2. Actualizar Estatus (Acción rápida)
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $nuevo_estatus = $conn->real_escape_string($_GET['accion']);
    $id_orden = (int)$_GET['id'];
    
    $conn->query("UPDATE ordenes SET status = '$nuevo_estatus' WHERE id = $id_orden");
    
    // Recargar manteniendo el filtro y la página
    $filtro_actual = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';
    $pag_actual = isset($_GET['pag']) ? $_GET['pag'] : 1;
    echo "<script>window.location.href='dashboard.php?vista=ordenes&filtro=$filtro_actual&pag=$pag_actual';</script>";
    exit;
}

// --- CONFIGURACIÓN DE PAGINACIÓN Y FILTROS ---

// A. Obtener filtro actual
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';

// B. Configurar cláusula WHERE según el filtro
$condicion_sql = "";
if ($filtro == 'proceso')     $condicion_sql = " WHERE o.status = 'En proceso'";
elseif ($filtro == 'aceptado') $condicion_sql = " WHERE o.status = 'Aceptado'";
elseif ($filtro == 'cancelado')$condicion_sql = " WHERE o.status = 'Cancelado'";
// Nota: Si hay un estatus 'Nuevo' en tu lógica pero no en el ENUM, ajusta aquí si es necesario.

// C. Configurar Paginación
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pag']) && is_numeric($_GET['pag']) ? (int)$_GET['pag'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
$inicio_query = ($pagina_actual - 1) * $registros_por_pagina;

// D. CONSULTA 1: Contar Total de Registros (con el filtro aplicado)
$sql_count = "SELECT COUNT(*) as total FROM ordenes o $condicion_sql";
$res_count = $conn->query($sql_count);
$row_count = $res_count->fetch_assoc();
$total_registros = $row_count['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// E. CONSULTA 2: Traer los datos (con LIMIT y OFFSET)
$sql_data = "SELECT o.*, c.nombre AS nombre_cliente, c.direccion AS direccion_cliente 
             FROM ordenes o 
             LEFT JOIN clientes c ON o.fk_cliente = c.id
             $condicion_sql
             ORDER BY o.id DESC 
             LIMIT $inicio_query, $registros_por_pagina";

$result = $conn->query($sql_data);
?>

<style>
    .orders-wrapper { max-width: 1000px; margin: 0 auto; }
    .page-header { margin-bottom: 20px; }
    .page-header h2 { margin: 0; color: #1e293b; }
    
    .status-tabs { display: flex; gap: 10px; margin-bottom: 25px; overflow-x: auto; padding-bottom: 5px; }
    .tab-link {
        padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500;
        text-decoration: none; color: #64748B; background: white; border: 1px solid #e2e8f0;
        transition: all 0.2s; white-space: nowrap;
    }
    .tab-link:hover { background: #f1f5f9; }
    .tab-link.active { background: #0F172A; color: white; border-color: #0F172A; }

    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; }

    .order-item { padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 15px; }
    @media(min-width: 768px) { .order-item { flex-direction: row; align-items: center; justify-content: space-between; } }
    .order-item:last-child { border-bottom: none; }
    .order-item:hover { background-color: #F8FAFC; }

    .order-main { display: flex; gap: 15px; align-items: flex-start; }
    .plan-icon { width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .bg-res { background: #DBEAFE; color: #2563EB; }
    .bg-com { background: #F3E8FF; color: #9333EA; }
    .bg-ok { background: #DCFCE7; color: #16A34A; }
    .bg-can { background: #FEE2E2; color: #EF4444; }

    .order-details h4 { margin: 0 0 5px 0; font-size: 1rem; color: #1e293b; }
    .order-meta { font-size: 0.85rem; color: #64748B; display: flex; flex-direction: column; gap: 3px; }
    .meta-row { display: flex; align-items: center; gap: 6px; }

    .order-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }
    @media(max-width: 768px) { .order-actions { align-items: flex-start; } }

    .status-badge { padding: 5px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .st-proceso { background: #E0F2FE; color: #0369A1; }
    .st-aceptado { background: #DCFCE7; color: #15803D; }
    .st-cancelado { background: #FEE2E2; color: #B91C1C; }
    .st-default { background: #F1F5F9; color: #64748B; }

    .action-group { display: flex; gap: 5px; }
    .btn-mini { padding: 5px 10px; border-radius: 4px; border: 1px solid #e2e8f0; background: white; color: #475569; font-size: 0.8rem; cursor: pointer; text-decoration: none; transition: background 0.2s; }
    .btn-mini:hover { background: #f1f5f9; color: #0F172A; border-color: #cbd5e1; }

    /* Paginación */
    .pagination-container {
        padding: 20px; display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid #f1f5f9; background-color: #FAFAFA;
    }
    .page-info { font-size: 0.85rem; color: #64748B; }
    .pagination-controls { display: flex; gap: 5px; }
    .page-link {
        padding: 6px 12px; border: 1px solid #e2e8f0; background: white; color: #333;
        text-decoration: none; border-radius: 4px; font-size: 0.85rem; transition: all 0.2s;
    }
    .page-link:hover { background-color: #f1f5f9; border-color: #cbd5e1; }
    .page-link.active { background-color: #0F172A; color: white; border-color: #0F172A; }
    .page-link.disabled { opacity: 0.5; pointer-events: none; cursor: default; }

    @media (max-width: 900px) {
        .orders-wrapper { padding: 0 15px; }
        .card-box { border-radius: 10px; }
    }
    @media (max-width: 600px) {
        .order-main { flex-direction: column; width: 100%; }
        .order-actions { width: 100%; align-items: flex-start; }
        .action-group { width: 100%; flex-wrap: wrap; }
        .pagination-container { flex-direction: column; align-items: flex-start; gap: 10px; }
    }

</style>

<div class="orders-wrapper view-shell">

    <div class="page-header">
        <h2>Gestión de Órdenes</h2>
        <p style="color: #64748B; margin-top: 5px;">
            Mostrando <?php echo $result->num_rows; ?> de <?php echo $total_registros; ?> órdenes
            <?php if($filtro != 'todos') echo "(Filtrado por: ".ucfirst($filtro).")"; ?>
        </p>
    </div>

    <div class="status-tabs">
        <a href="?vista=ordenes&filtro=todos&pag=1" class="tab-link <?php echo $filtro == 'todos' ? 'active' : ''; ?>">Todas</a>
        <a href="?vista=ordenes&filtro=proceso&pag=1" class="tab-link <?php echo $filtro == 'proceso' ? 'active' : ''; ?>">En Proceso</a>
        <a href="?vista=ordenes&filtro=aceptado&pag=1" class="tab-link <?php echo $filtro == 'aceptado' ? 'active' : ''; ?>">Aceptadas</a>
        <a href="?vista=ordenes&filtro=cancelado&pag=1" class="tab-link <?php echo $filtro == 'cancelado' ? 'active' : ''; ?>">Canceladas</a>
    </div>

    <div class="card-box">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($orden = $result->fetch_assoc()): ?>
                
                <?php 
                    // 1. Datos del Plan
                    $plan = isset($orden['plan']) ? $orden['plan'] : 'Plan General';
                    $es_comercial = stripos($plan, 'Comercial') !== false || stripos($plan, 'Negocio') !== false;
                    $icon_class = 'bg-res'; // Default Azul
                    
                    // 2. Datos del Estatus
                    $estatus = isset($orden['status']) ? $orden['status'] : 'Nuevo';
                    $st_class = 'st-default';

                    if($estatus == 'En proceso') { $st_class = 'st-proceso'; }
                    if($estatus == 'Aceptado') { $st_class = 'st-aceptado'; $icon_class = 'bg-ok'; }
                    if($estatus == 'Cancelado') { $st_class = 'st-cancelado'; $icon_class = 'bg-can'; }
                    if($es_comercial && $estatus != 'Aceptado' && $estatus != 'Cancelado') { $icon_class = 'bg-com'; }

                    // 3. Nombre del cliente
                    $nombre_cliente = isset($orden['nombre_cliente']) ? $orden['nombre_cliente'] : 'Cliente Desconocido';
                ?>

                <div class="order-item">
                    <div class="order-main">
                        <div class="plan-icon <?php echo $icon_class; ?>">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <div class="order-details">
                            <h4>
                                <?php echo htmlspecialchars($nombre_cliente); ?>
                                <span style="font-weight:normal; font-size:0.8rem; color:#94A3B8;">(#<?php echo $orden['numero_orden']; ?>)</span>
                            </h4>
                            
                            <div class="order-meta">
                                <div class="meta-row">
                                    <i class="fa-solid fa-hashtag" style="width:15px;"></i> 
                                    Solicitud: <?php echo htmlspecialchars($orden['numero_solicitud']); ?>
                                </div>
                                <div class="meta-row">
                                    <i class="fa-solid fa-location-dot" style="width:15px;"></i> 
                                    <?php echo htmlspecialchars($orden['referencia'] ?? 'Sin referencia'); ?>
                                </div>
                                <div class="meta-row">
                                    <i class="fa-regular fa-calendar" style="width:15px;"></i> 
                                    <?php echo isset($orden['fecha_registro']) ? date('d/m/Y', strtotime($orden['fecha_registro'])) : '---'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <span class="status-badge <?php echo $st_class; ?>"><?php echo $estatus; ?></span>
                        
                        <div class="action-group">
                            <?php if($estatus == 'En proceso'): ?>
                                <a href="?vista=ordenes&id=<?php echo $orden['id']; ?>&accion=Aceptado&filtro=<?php echo $filtro; ?>&pag=<?php echo $pagina_actual; ?>" class="btn-mini" style="color:green;" title="Aceptar">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="?vista=ordenes&id=<?php echo $orden['id']; ?>&accion=Cancelado&filtro=<?php echo $filtro; ?>&pag=<?php echo $pagina_actual; ?>" class="btn-mini" style="color:red;" title="Cancelar">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            <?php endif; ?>

                             <?php if($estatus == 'Cancelado'): ?>
                                <a href="?vista=ordenes&id=<?php echo $orden['id']; ?>&accion=En proceso&filtro=<?php echo $filtro; ?>&pag=<?php echo $pagina_actual; ?>" class="btn-mini" title="Reactivar">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div style="padding:40px; text-align:center; color:#64748B;">
                <i class="fa-solid fa-folder-open" style="font-size:3rem; color:#e2e8f0; margin-bottom:10px;"></i>
                <p>No se encontraron órdenes.</p>
            </div>
        <?php endif; ?>

        <?php if ($total_paginas > 1): ?>
        <div class="pagination-container">
            <div class="page-info">
                Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
            </div>
            
            <div class="pagination-controls">
                
                <?php if ($pagina_actual > 1): ?>
                    <a href="dashboard.php?vista=ordenes&filtro=<?php echo $filtro; ?>&pag=<?php echo ($pagina_actual - 1); ?>" class="page-link">
                        <i class="fa-solid fa-chevron-left"></i> Anterior
                    </a>
                <?php else: ?>
                    <span class="page-link disabled"><i class="fa-solid fa-chevron-left"></i> Anterior</span>
                <?php endif; ?>

                <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                    <?php if ($i == 1 || $i == $total_paginas || ($i >= $pagina_actual - 2 && $i <= $pagina_actual + 2)): ?>
                        <a href="dashboard.php?vista=ordenes&filtro=<?php echo $filtro; ?>&pag=<?php echo $i; ?>" 
                           class="page-link <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                           <?php echo $i; ?>
                        </a>
                    <?php elseif ($i == $pagina_actual - 3 || $i == $pagina_actual + 3): ?>
                        <span style="padding: 0 5px;">...</span>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="dashboard.php?vista=ordenes&filtro=<?php echo $filtro; ?>&pag=<?php echo ($pagina_actual + 1); ?>" class="page-link">
                        Siguiente <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <span class="page-link disabled">Siguiente <i class="fa-solid fa-chevron-right"></i></span>
                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
