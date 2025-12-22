<?php


// 1. Conexión segura
if (!isset($conn)) {
    if (file_exists("includes/conexion.php")) require_once "includes/conexion.php";
    elseif (file_exists("../includes/conexion.php")) require_once "../includes/conexion.php";
}

// 2. KPI ÚNICO: Total Clientes (Consulta Real)
$total_clientes = 0;
$check_cli = $conn->query("SHOW TABLES LIKE 'clientes'");
if($check_cli && $check_cli->num_rows > 0) {
    $row_c = $conn->query("SELECT COUNT(*) as total FROM clientes");
    if($row_c) $total_clientes = $row_c->fetch_assoc()['total'];
}



$labels_semana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$consumo_descarga = [1250, 1400, 1350, 1600, 1850, 2100, 1950]; 
$consumo_carga    = [350, 400, 380, 450, 500, 600, 550];

// Gráfica 2: Distribución de Planes
$data_planes = [60, 40]; 

// Gráfica 3: Tráfico en vivo
$data_velocidad = [450, 480, 470, 510, 500, 530, 520];
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: clamp(18px, 4vw, 32px) 0;
    }
    
    .welcome-section { margin-bottom: 25px; }
    .welcome-section h2 { margin: 0; color: #1e293b; font-size: 1.6rem; font-weight: 700; }
    .welcome-section p { margin: 5px 0 0; color: #64748B; font-size: 0.95rem; }

    /* --- KPI SINGLE CARD (Ajustado para uno solo) --- */
    .kpi-row {
        display: flex; 
        gap: 20px; 
        margin-bottom: 30px;
    }
    
    .kpi-card {
        background: white; border-radius: 16px; padding: 25px;
        border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex; align-items: center; justify-content: space-between;
        transition: all 0.3s ease;
        /* Tamaño fijo o mínimo para que se vea bien siendo único */
        width: 100%; max-width: 350px; 
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }
    
    .kpi-info h4 { margin: 0; color: #94A3B8; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .kpi-info span { display: block; font-size: 2.2rem; font-weight: 800; color: #0F172A; margin-top: 5px; letter-spacing: -1px; }
    
    .kpi-icon { width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .icon-blue { background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%); color: #2563EB; }

    /* --- GRÁFICAS --- */
    .charts-grid-main { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 25px; }
    .charts-grid-secondary { display: grid; grid-template-columns: 1fr; gap: 25px; } 
    @media (max-width: 1024px) { .charts-grid-main { grid-template-columns: 1fr; } }

    .chart-container {
        background: white; border-radius: 16px; padding: 25px;
        border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        position: relative;
        min-width: 0;
    }
    .chart-container.main-chart { min-height: 400px; }
    .chart-container.small-chart { min-height: 320px; }

    .chart-body {
        width: 100%;
        height: 360px;
    }
    .chart-body-lg {
        height: clamp(280px, 50vw, 420px);
    }
    .chart-body canvas {
        width: 100% !important;
        height: 100% !important;
    }

    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .chart-header h3 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b; }
    
    .chart-legend-custom { display: flex; gap: 15px; font-size: 0.85rem; color: #64748B; }
    .legend-item { display: flex; align-items: center; gap: 6px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; }

    /* Badge En Vivo */
    .badge-live { 
        background: #FEE2E2; color: #EF4444; padding: 4px 10px; border-radius: 20px; 
        font-size: 0.7rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 6px; 
    }
    .dot-anim { width: 8px; height: 8px; background: #EF4444; border-radius: 50%; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } 100% { opacity: 1; transform: scale(1); } }

    @media (max-width: 900px) {
        .dashboard-wrapper { padding: 0 15px; }
        .kpi-row { flex-wrap: wrap; }
        .kpi-card { max-width: 100%; }
        .chart-container { padding: 20px; }
    }

    @media (max-width: 600px) {
        .welcome-section h2 { font-size: 1.35rem; }
        .welcome-section p { font-size: 0.9rem; }
        .kpi-row { flex-direction: column; gap: 15px; }
        .kpi-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            width: 100%;
            padding: 20px;
            border-radius: 14px;
        }
        .chart-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .chart-legend-custom { flex-wrap: wrap; }
        .charts-grid-main,
        .charts-grid-secondary { gap: 18px; }
        .chart-container {
            padding: 20px;
            border-radius: 14px;
        }
        .chart-container.main-chart { min-height: 320px; }
        .chart-container.small-chart { min-height: 260px; }
        .chart-body {
            height: 260px;
        }
        .chart-header h3 { font-size: 1rem; }
        .dashboard-wrapper { padding: 20px 0 60px; }
    }

</style>

<div class="dashboard-wrapper view-shell">
    
    <div class="welcome-section">
        <h2>Hola, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Administrador'; ?> 👋</h2>
        <p>Resumen del estado de la red.</p>
    </div>

    <div class="kpi-row">
        <div class="kpi-card">
            <div class="kpi-info">
                <h4>Total Clientes Activos</h4>
                <span><?php echo $total_clientes; ?></span>
            </div>
            <div class="kpi-icon icon-blue">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <div class="charts-grid-main">
        
        <div class="chart-container main-chart">
            <div class="chart-header">
                <h3>Consumo de Datos Semanal</h3>
                <div class="chart-legend-custom">
                    <div class="legend-item"><div class="legend-dot" style="background:#3B82F6;"></div> Descarga</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#A855F7;"></div> Carga</div>
                </div>
            </div>
            <div class="chart-body chart-body-lg">
                <canvas id="weeklyDataChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container main-chart">
             <div class="chart-header">
                <h3>Distribución de Servicios</h3>
            </div>
            <div style="position: relative; height: 300px; display: flex; justify-content: center; align-items: center;">
                <canvas id="plansDoughnutChart"></canvas>
                <div style="position: absolute; text-align: center; pointer-events: none;">
                    <span style="font-size: 1.8rem; font-weight: 800; color: #1e293b; display: block;"><?php echo $total_clientes; ?></span>
                    <span style="font-size: 0.8rem; color: #64748B;">Total</span>
                </div>
            </div>
        </div>
    </div>

    <div class="charts-grid-secondary"> 
        <div class="chart-container small-chart">
            <div class="chart-header">
                <h3>Velocidad Promedio (Mbps)</h3>
                <div class="badge-live"><div class="dot-anim"></div> EN VIVO</div>
            </div>
            <div style="width: 100%; height: 240px;">
                <canvas id="liveSpeedChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94A3B8';
    Chart.defaults.scale.grid.color = '#F1F5F9';

    // 1. CONSUMO (Área)
    const ctxWeekly = document.getElementById('weeklyDataChart').getContext('2d');
    
    let gradBlue = ctxWeekly.createLinearGradient(0, 0, 0, 400);
    gradBlue.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); gradBlue.addColorStop(1, 'rgba(59, 130, 246, 0.0)');
    
    let gradPurple = ctxWeekly.createLinearGradient(0, 0, 0, 400);
    gradPurple.addColorStop(0, 'rgba(168, 85, 247, 0.4)'); gradPurple.addColorStop(1, 'rgba(168, 85, 247, 0.0)');

    new Chart(ctxWeekly, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels_semana); ?>,
            datasets: [
                { label: 'Descarga', data: <?php echo json_encode($consumo_descarga); ?>, borderColor: '#3B82F6', backgroundColor: gradBlue, tension: 0.4, fill: true, borderWidth: 3, pointRadius: 0, pointHoverRadius: 6 },
                { label: 'Carga', data: <?php echo json_encode($consumo_carga); ?>, borderColor: '#A855F7', backgroundColor: gradPurple, tension: 0.4, fill: true, borderWidth: 3, pointRadius: 0, pointHoverRadius: 6 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { borderDash: [5, 5] } }, x: { grid: { display: false } } }, interaction: { mode: 'nearest', axis: 'x', intersect: false } }
    });

    // 2. PLANES (Dona)
    const ctxPlans = document.getElementById('plansDoughnutChart').getContext('2d');
    new Chart(ctxPlans, {
        type: 'doughnut',
        data: {
            labels: ['Residencial', 'Comercial'],
            datasets: [{
                data: <?php echo json_encode($data_planes); ?>,
                backgroundColor: ['#3B82F6', '#8B5CF6'],
                borderWidth: 0, hoverOffset: 15
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '80%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } } }
    });

    // 3. VELOCIDAD (Línea)
    const ctxLive = document.getElementById('liveSpeedChart').getContext('2d');
    let gradGreen = ctxLive.createLinearGradient(0, 0, 0, 300);
    gradGreen.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); gradGreen.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

    new Chart(ctxLive, {
        type: 'line',
        data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', 'Ahora'],
            datasets: [{ label: 'Mbps', data: <?php echo json_encode($data_velocidad); ?>, borderColor: '#10B981', backgroundColor: gradGreen, tension: 0.3, fill: true, borderWidth: 2, pointRadius: 4, pointBackgroundColor: '#fff', pointBorderColor: '#10B981' }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { display: false }, x: { grid: { display: false } } } }
    });
</script>
