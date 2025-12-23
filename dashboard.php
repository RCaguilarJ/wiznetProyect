<?php
require_once "includes/conexion.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$vista = isset($_GET['vista']) ? $_GET['vista'] : 'inicio';

function is_active($target, $current) {
    return $target === $current ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wiznet</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Mostrar u ocultar el menú">
    <i class="fa-solid fa-bars"></i>
</button>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="dashboard-container">
    
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <i class="fa-solid fa-circle-nodes" style="color: #3B82F6; font-size: 1.5rem;"></i>
                <span class="sidebar-brand-text" style="margin-left: 10px; font-weight: bold; font-size: 1.2rem;">WIZNET</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            
            <a href="?vista=inicio" class="menu-item <?php echo is_active('inicio', $vista); ?>">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            

            <div class="menu-category">Mi Cuenta</div>

            <a href="?vista=mi_informacion" class="menu-item <?php echo is_active('mi_informacion', $vista); ?>">
                <i class="fa-regular fa-user"></i> Mi Información
            </a>
            <a href="?vista=cuentas" class="menu-item <?php echo is_active('cuentas', $vista); ?>">
                <i class="fa-regular fa-credit-card"></i> Cuentas Bancarias
            </a>

            <div class="menu-category">Paquetes de Internet</div>
            <a href="?vista=internet_residencial" class="menu-item <?php echo is_active('internet_residencial', $vista); ?>">
                <i class="fa-solid fa-wifi"></i> Internet Residencial
            </a>
            <a href="?vista=internet_comercial" class="menu-item <?php echo is_active('internet_comercial', $vista); ?>">
                <i class="fa-solid fa-building"></i> Internet Comercial
            </a>
            <a href="?vista=contratacion" class="menu-item <?php echo is_active('contratacion', $vista); ?>">
                <i class="fa-regular fa-file-lines"></i> Formulario de Contratación
            </a>

            <div class="menu-category">Finanzas</div>
            <a href="?vista=reportar_pago" class="menu-item <?php echo is_active('reportar_pago', $vista); ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i> Reportar Pago
            </a>

            <div class="menu-category">Soporte</div>
            <a href="?vista=soporte" class="menu-item <?php echo is_active('soporte', $vista); ?>">
                <i class="fa-regular fa-comment-dots"></i> Ticket de Soporte
            </a>


            <div class="menu-category">Contacto</div>
            <a href="?vista=contacto" class="menu-item <?php echo is_active('contacto', $vista); ?>">
                <i class="fa-regular fa-envelope"></i> Solicitud de Contacto
            </a>

        </nav>

        <div style="padding: 10px; margin-top: auto;">
            <a href="index.php" class="menu-item logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="main-content">
        <?php

            $archivo = "./vistas/" . $vista . ".php";

            if (file_exists($archivo)) {
                include $archivo;
            } else {
                // Página de error 404 estilizada
                echo "<div style='text-align:center; padding:50px;'>";
                echo "<i class='fa-solid fa-triangle-exclamation' style='font-size:3rem; color:#f59e0b;'></i>";
                echo "<h2 style='color:#333;'>Vista no encontrada</h2>";
                echo "<p style='color:#666;'>La sección '<strong>" . htmlspecialchars($vista) . "</strong>' no existe o está en construcción.</p>";
                echo "</div>";
            }
        ?>
    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const body = document.body;
        const toggleBtn = document.getElementById('sidebarToggle');
        const backdrop = document.getElementById('sidebarBackdrop');

        function closeSidebar() {
            body.classList.remove('sidebar-open');
        }

        if (toggleBtn && backdrop) {
            toggleBtn.addEventListener('click', () => {
                body.classList.toggle('sidebar-open');
            });

            backdrop.addEventListener('click', closeSidebar);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                closeSidebar();
            }
        });
    });
</script>

</body>
</html>
