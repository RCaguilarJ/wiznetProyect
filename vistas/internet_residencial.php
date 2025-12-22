<style>
    /* Contenedor centralizado para los planes */
    .pricing-container {
        max-width: 900px; /* Ancho máximo para que se vea como en el diseño */
        margin: 0 auto;
    }

    /* Cabecera de la sección (Icono y textos) */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .header-icon {
        background-color: #DBEAFE; /* Azul suave */
        color: #2563EB; /* Azul fuerte */
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    .section-header h2 {
        margin: 0 0 10px 0;
        color: #1e293b;
    }
    .section-header p {
        color: #64748B;
        margin: 0;
    }

    /* Estilos Generales de las Tarjetas */
    .plan-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 40px;
        margin-bottom: 30px;
        text-align: center;
        position: relative; 
        transition: transform 0.2s;
    }
    
    /* Modificador para la tarjeta destacada (Más Popular) */
    .plan-card.featured {
        border: 2px solid #3B82F6; 
        padding-top: 0; 
        overflow: hidden; 
    }

    /* Header de la tarjeta destacada */
    .featured-header {
        background-color: #3B82F6;
        color: white;
        padding: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 30px;
        
        margin-left: -40px; 
        margin-right: -40px;
    }

    /* Precios y Velocidad */
    .plan-name {
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 10px;
    }
    .plan-price {
        font-size: 2.5rem;
        color: #2563EB;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    .plan-price span {
        font-size: 0.9rem;
        color: #64748B;
        font-weight: normal;
        margin-top: 10px;
    }
    .plan-speed {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 5px 0 0 0;
    }
    .plan-speed-label {
        font-size: 0.8rem;
        color: #64748B;
        margin-bottom: 30px;
        display: block;
    }

    /* Lista de características */
    .features-list {
        text-align: left; 
        margin-bottom: 30px;
        padding-left: 0; 
        display: inline-block; 
        width: 100%;
    }
    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: #334155;
    }
    .check-icon {
        color: #10B981; /* Verde */
        font-size: 0.8rem;
    }

    /* Botones de acción */
    .btn-plan {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        display: block;
        box-sizing: border-box;
    }
    .btn-outline {
        border: 1px solid #e2e8f0;
        background: white;
        color: #1e293b;
    }
    .btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .btn-solid {
        background: #000022; /* Color oscuro del diseño */
        color: white;
        border: none;
    }
    .btn-solid:hover {
        background: #1e1e40;
    }

    /* Sección de Beneficios Inferior */
    .benefits-section {
        background-color: #F1F5F9;
        border-radius: 8px;
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columnas iguales */
        gap: 20px;
        margin-top: 40px;
    }
    .benefit-item h4 {
        margin: 0 0 5px 0;
        font-size: 0.95rem;
        color: #1e293b;
    }
    .benefit-item p {
        margin: 0;
        font-size: 0.8rem;
        color: #64748B;
        line-height: 1.4;
    }
    @media (max-width: 900px) {
        .pricing-container { padding: 0 15px; }
        .plan-card { padding: 25px; }
        .featured-header { margin-left: -25px; margin-right: -25px; }
    }
    @media (max-width: 600px) {
        .plan-card { padding: 20px; }
        .featured-header { margin-left: -20px; margin-right: -20px; }
        .features-list { display: block; }
        .benefits-section { grid-template-columns: 1fr; padding: 20px; }
    }
</style>

<div class="pricing-container view-shell">

    <div class="section-header">
        <div class="header-icon">
            <i class="fa-solid fa-wifi"></i>
        </div>
        <h2>Internet Residencial</h2>
        <p>Encuentra el plan perfecto para tu hogar</p>
    </div>

    <div class="plan-card">
        <div class="plan-name">Plan Básico</div>
        <div class="plan-price">$25 <span>por mes</span></div>
        <div class="plan-speed">10 Mbps</div>
        <span class="plan-speed-label">Velocidad de descarga</span>

        <div class="features-list">
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Navegación web</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Redes sociales</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Email</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Streaming básico</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Soporte 24/7</div>
        </div>

        <a href="?vista=contratacion&plan=basico" class="btn-plan btn-outline">Contratar Plan</a>
    </div>

    <div class="plan-card featured">
        <div class="featured-header">Más Popular</div>

        <div class="plan-name">Plan Hogar</div>
        <div class="plan-price">$45 <span>por mes</span></div>
        <div class="plan-speed">30 Mbps</div>
        <span class="plan-speed-label">Velocidad de descarga</span>

        <div class="features-list">
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Todo lo del Plan Básico</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Streaming HD</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Videollamadas</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Gaming online</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Conexión estable</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Router WiFi incluido</div>
        </div>

        <a href="?vista=contratacion&plan=hogar" class="btn-plan btn-solid">Contratar Plan</a>
    </div>

    <div class="plan-card">
        <div class="plan-name">Plan Premium</div>
        <div class="plan-price">$75 <span>por mes</span></div>
        <div class="plan-speed">100 Mbps</div>
        <span class="plan-speed-label">Velocidad de descarga</span>

        <div class="features-list">
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Todo lo del Plan Hogar</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Streaming 4K</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Múltiples dispositivos</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Velocidad garantizada</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Instalación gratis</div>
            <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Router WiFi Mesh</div>
        </div>

        <a href="?vista=contratacion&plan=premium" class="btn-plan btn-outline">Contratar Plan</a>
    </div>

    <div style="margin-top: 40px; margin-bottom: 10px;">
        <h4 style="margin: 0; color: #333; font-size: 0.95rem;">Beneficios Adicionales</h4>
    </div>
    
    <div class="benefits-section">
        <div class="benefit-item">
            <h4>Instalación Profesional</h4>
            <p>Técnicos certificados instalarán tu servicio</p>
        </div>
        <div class="benefit-item">
            <h4>Sin Contratos</h4>
            <p>Cancela cuando quieras sin penalizaciones</p>
        </div>
        <div class="benefit-item">
            <h4>Soporte 24/7</h4>
            <p>Asistencia técnica disponible todo el tiempo</p>
        </div>
    </div>

</div>
