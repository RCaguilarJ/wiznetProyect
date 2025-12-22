<?php

// 1. Conexión a Base de Datos
if (!isset($conn)) {
    if (file_exists("includes/conexion.php")) {
        require_once "includes/conexion.php";
    } elseif (file_exists("../includes/conexion.php")) {
        require_once "../includes/conexion.php";
    }
}

// --- CONFIGURACIÓN DE PAGINACIÓN ---
$registros_por_pagina = 10;

// 1. Detectar página actual (Si no existe o es inválida, forzar a 1)
$pagina_actual = isset($_GET['pag']) && is_numeric($_GET['pag']) ? (int)$_GET['pag'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// 2. Calcular el OFFSET (desde dónde empieza a leer la BD)
$inicio_query = ($pagina_actual - 1) * $registros_por_pagina;

// 3. Contar TOTAL de clientes (para saber cuántas páginas dibujar)
$sql_total = "SELECT COUNT(*) as total FROM clientes";
$resultado_total = $conn->query($sql_total);
$fila_total = $resultado_total->fetch_assoc();
$total_registros = $fila_total['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// 4. Consulta LIMITADA (Esta es la que carga solo 10)
// 
$sql = "SELECT * FROM clientes ORDER BY id DESC LIMIT $inicio_query, $registros_por_pagina";
$result = $conn->query($sql);

?>

<style>
    /* Estilos Generales */
    .clients-wrapper { max-width: 1000px; margin: 0 auto; }
    .header-flex { display: flex; justify-content: space-between; align-items: end; margin-bottom: 25px; }
    .page-header { margin: 0; }
    
    .btn-add {
        background-color: #0F172A; color: white; padding: 10px 20px; border-radius: 6px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        display: flex; align-items: center; gap: 8px; transition: background 0.2s; border: none; cursor: pointer;
    }
    .btn-add:hover { background-color: #1e293b; }

    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; }

    /* Cliente Item */
    .client-item { display: flex; align-items: center; justify-content: space-between; padding: 20px 25px; border-bottom: 1px solid #f1f5f9; transition: background 0.1s; }
    .client-item:last-child { border-bottom: none; }
    .client-item:hover { background-color: #F8FAFC; }

    /* Avatar Inteligente */
    .client-info { display: flex; align-items: center; gap: 15px; }
    .client-avatar {
        width: 45px; height: 45px; 
        background-color: #DBEAFE; color: #2563EB; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-size: 1.2rem; font-weight: 700; text-transform: uppercase;
        border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .client-details h4 { margin: 0 0 4px 0; font-size: 0.95rem; color: #1e293b; font-weight: 600; }
    .client-details p { margin: 0; font-size: 0.85rem; color: #64748B; display: flex; gap: 10px; }
    .separator { color: #cbd5e1; }

    .client-actions { display: flex; align-items: center; gap: 20px; }
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-active { background-color: #DCFCE7; color: #166534; }
    
    .action-btn { color: #94A3B8; cursor: pointer; font-size: 1.1rem; transition: color 0.2s; text-decoration: none; }
    .action-btn:hover { color: #3B82F6; }
    .action-btn.delete:hover { color: #EF4444; }

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

    .empty-state { padding: 40px; text-align: center; color: #64748B; }

    @media (max-width: 900px) {
        .clients-wrapper { padding: 0 15px; }
        .header-flex { flex-direction: column; align-items: flex-start; gap: 15px; }
        .btn-add { width: 100%; justify-content: center; }
    }
    @media (max-width: 600px) {
        .client-item { flex-direction: column; align-items: flex-start; gap: 15px; padding: 15px; }
        .client-actions { width: 100%; justify-content: space-between; }
        .client-details p { flex-direction: column; gap: 5px; }
        .pagination-container { flex-direction: column; gap: 10px; align-items: flex-start; }
    }
</style>

<div class="clients-wrapper view-shell">

    <div class="header-flex">
        <div class="page-header">
            <h2 style="margin:0; color:#1e293b;">Directorio de Clientes</h2>
            <p style="margin:5px 0 0 0; color:#64748B; font-size:0.9rem;">
                Mostrando <?php echo $result->num_rows; ?> clientes (Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>)
            </p>
        </div>
        
        <a href="dashboard.php?vista=clientes_agregar" class="btn-add">
            <i class="fa-solid fa-plus"></i> Agregar Cliente
        </a>
    </div>

    <div class="card-box">
        
        <?php if ($result && $result->num_rows > 0): ?>
            
            <?php while($cliente = $result->fetch_assoc()): ?>
                <div class="client-item">
                    
                    <div class="client-info">
                        <div class="client-avatar">
                            <?php 
                                $nombre_completo = isset($cliente['nombre']) ? $cliente['nombre'] : '?';
                                
                                // EXPRESIÓN REGULAR:
                                
                                if (preg_match('/[a-zA-ZñÑáéíóúÁÉÍÓÚ]/', $nombre_completo, $coincidencias)) {
                                    $inicial = $coincidencias[0]; 
                                } else {
                                   
                                    $inicial = substr($nombre_completo, 0, 1);
                                }
                                echo strtoupper($inicial); 
                            ?>
                        </div>

                        <div class="client-details">
                            <h4><?php echo htmlspecialchars($cliente['nombre']); ?></h4>
                            <p>
                                <span title="Número de Cliente">
                                    <i class="fa-regular fa-id-card"></i> 
                                    <?php echo htmlspecialchars($cliente['numero'] ?? '---'); ?>
                                </span>
                                <span class="separator">|</span>
                                <span>
                                    <i class="fa-solid fa-phone"></i> 
                                    <?php echo htmlspecialchars($cliente['telefono_1'] ?? '---'); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="client-actions">
                        <span class="badge badge-active">Activo</span>
                        <a href="dashboard.php?vista=clientes_editar&id=<?php echo $cliente['id']; ?>" class="action-btn" title="Editar">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a href="#" class="action-btn delete" title="Eliminar"><i class="fa-regular fa-trash-can"></i></a>
                    </div>

                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-users" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 15px;"></i>
                <p>No hay clientes registrados.</p>
            </div>
        <?php endif; ?>

        <?php if ($total_paginas > 1): ?>
        <div class="pagination-container">
            <div class="page-info">
                Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
            </div>
            
            <div class="pagination-controls">
                
                <?php if ($pagina_actual > 1): ?>
                    <a href="dashboard.php?vista=clientes&pag=<?php echo ($pagina_actual - 1); ?>" class="page-link">
                        <i class="fa-solid fa-chevron-left"></i> Anterior
                    </a>
                <?php else: ?>
                    <span class="page-link disabled"><i class="fa-solid fa-chevron-left"></i> Anterior</span>
                <?php endif; ?>

                <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                    <?php if ($i == 1 || $i == $total_paginas || ($i >= $pagina_actual - 2 && $i <= $pagina_actual + 2)): ?>
                        <a href="dashboard.php?vista=clientes&pag=<?php echo $i; ?>" 
                           class="page-link <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                           <?php echo $i; ?>
                        </a>
                    <?php elseif ($i == $pagina_actual - 3 || $i == $pagina_actual + 3): ?>
                        <span style="padding: 0 5px;">...</span>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="dashboard.php?vista=clientes&pag=<?php echo ($pagina_actual + 1); ?>" class="page-link">
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
