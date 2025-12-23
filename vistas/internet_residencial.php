<style>
    /* Contenedor centralizado para los planes */
    .pricing-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Cabecera de la sección */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .header-icon {
        background-color: #DBEAFE;
        color: #2563EB;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    .section-header h2 { margin: 0 0 10px 0; color: #1e293b; }
    .section-header p { color: #64748B; margin: 0; }

    /* Estilos de las Tarjetas */
    .plan-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 40px;
        margin-bottom: 30px;
        text-align: center;
        position: relative; 
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    /* Destacado (Plan Medio) */
    .plan-card.featured {
        border: 2px solid #3B82F6; 
        padding-top: 0; 
        overflow: hidden; 
    }
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

    /* Textos */
    .plan-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .plan-desc {
        font-size: 0.85rem;
        color: #64748B;
        margin-bottom: 20px;
        min-height: 40px; /* Para alinear alturas */
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
        font-size: 1.4rem;
        font-weight: 800;
        color: #1e293b;
        margin: 5px 0 0 0;
    }
    .plan-speed-label {
        font-size: 0.8rem;
        color: #64748B;
        margin-bottom: 25px;
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
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #334155;
    }
    .check-icon { color: #10B981; font-size: 0.8rem; }
    .upload-icon { color: #3B82F6; font-size: 0.8rem; }

    /* Botones */
    .btn-plan {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: block;
        box-sizing: border-box;
    }
    .btn-outline { border: 1px solid #e2e8f0; background: white; color: #1e293b; }
    .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-solid { background: #000022; color: white; border: none; }
    .btn-solid:hover { background: #1e1e40; }

    /* Grid Responsivo */
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        align-items: start;
    }

    /* Beneficios */
    .benefits-section {
        background-color: #F1F5F9;
        border-radius: 8px;
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 40px;
    }
    .benefit-item h4 { margin: 0 0 5px 0; font-size: 0.95rem; color: #1e293b; }
    .benefit-item p { margin: 0; font-size: 0.8rem; color: #64748B; line-height: 1.4; }
    
    @media (max-width: 768px) {
        .pricing-container { padding: 0 15px; }
        .benefits-section { grid-template-columns: 1fr; }
    }
</style>

<div class="pricing-container view-shell">

    <div class="section-header">
        <div class="header-icon"><i class="fa-solid fa-wifi"></i></div>
        <h2>Paquetes Internet Residencial</h2>
        <p>Conectividad confiable para tu hogar</p>
    </div>

    <div class="plans-grid">
        <div class="plan-card">
            <div class="plan-name">Paq. Básico Residencial</div>
            <div class="plan-desc">Ideal para consumos bajos, mensajería y tareas básicas.</div>
            
            <div class="plan-price">$300 <span>/mes</span></div>
            <div class="plan-speed">5 MB</div>
            <span class="plan-speed-label">Descarga</span>

            <div class="features-list">
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Navegación Ilimitada</div>
                <div class="feature-item"><i class="fa-solid fa-arrow-up upload-icon"></i> <strong>2 MB</strong> de Carga</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Mensajería instantánea</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Redes sociales básicas</div>
            </div>

            <a href="?vista=contratacion&plan=basico_residencial" class="btn-plan btn-outline">Contratar</a>
        </div>

        <div class="plan-card featured">
            <div class="featured-header">Recomendado</div>
            
            <div class="plan-name">Paq. Medio Residencial</div>
            <div class="plan-desc">Ideal para consumos medios y entretenimiento.</div>

            <div class="plan-price">$400 <span>/mes</span></div>
            <div class="plan-speed">7 MB</div>
            <span class="plan-speed-label">Descarga</span>

            <div class="features-list">
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Navegación Ilimitada</div>
                <div class="feature-item"><i class="fa-solid fa-arrow-up upload-icon"></i> <strong>3 MB</strong> de Carga</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Streaming estándar</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Videollamadas</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Teletrabajo básico</div>
            </div>

            <a href="?vista=contratacion&plan=medio_residencial" class="btn-plan btn-solid">Contratar</a>
        </div>

        <div class="plan-card">
            <div class="plan-name">Paq. Alto Residencial</div>
            <div class="plan-desc">Para consumos altos, descargas y múltiples dispositivos.</div>

            <div class="plan-price">$550 <span>/mes</span></div>
            <div class="plan-speed">10 MB</div>
            <span class="plan-speed-label">Descarga</span>

            <div class="features-list">
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Navegación Ilimitada</div>
                <div class="feature-item"><i class="fa-solid fa-arrow-up upload-icon"></i> <strong>5 MB</strong> de Carga</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Streaming HD</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Gaming online</div>
                <div class="feature-item"><i class="fa-solid fa-check check-icon"></i> Descargas rápidas</div>
            </div>

            <a href="?vista=contratacion&plan=alto_residencial" class="btn-plan btn-outline">Contratar</a>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #64748B; font-size: 0.85rem;">
        <p>* Consulte gastos de activación de servicio e instalación.</p>
    </div>
    
    <div class="benefits-section">
        <div class="benefit-item">
            <h4>Instalación Rápida</h4>
            <p>Agenda tu cita y conéctate en tiempo récord.</p>
        </div>
        <div class="benefit-item">
            <h4>Soporte Local</h4>
            <p>Atención personalizada cerca de ti.</p>
        </div>
        <div class="benefit-item">
            <h4>Sin Plazos Forzosos</h4>
            <p>Libertad para cambiar de plan cuando quieras.</p>
        </div>
    </div>

</div>