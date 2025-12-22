<style>
    /* Estilos específicos para Internet Comercial */
    
    .commercial-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Cabecera con icono morado */
    .comm-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .comm-icon-box {
        width: 60px;
        height: 60px;
        background-color: #F3E8FF; /* Morado muy claro */
        color: #9333EA; /* Morado vibrante */
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    .comm-header h2 {
        margin: 0 0 10px 0;
        color: #1e293b;
    }

    /* Tarjetas de Planes (Formato Ancho) */
    .business-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 25px;
        transition: box-shadow 0.2s;
    }
    .business-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    /* Título del plan */
    .biz-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .biz-desc {
        color: #64748B;
        font-size: 0.85rem;
        margin-bottom: 20px;
    }

    /* Sección de Precio y Velocidad  */
    .biz-price-box {
        background-color: #FAF5FF;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-bottom: 25px;
    }
    .biz-price {
        font-size: 2rem;
        font-weight: bold;
        color: #9333EA;
    }
    .biz-price span {
        font-size: 0.9rem;
        font-weight: normal;
        color: #64748B;
    }
    .biz-speed {
        display: block;
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
        margin-top: 5px;
    }

  
    .biz-features {
        margin-bottom: 25px;
    }
    .biz-features h5 {
        margin: 0 0 15px 0;
        font-size: 0.9rem;
        color: #333;
    }
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    .f-item {
        font-size: 0.85rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .f-item i {
        color: #10B981; /* Verde para los checks */
        font-size: 0.8rem;
    }

    /* Botones de acción */
    .biz-actions {
        display: flex;
        gap: 15px;
        flex-direction: column;
    }
    
    @media (min-width: 600px) {
        .biz-actions {
            flex-direction: row;
        }
        .biz-btn {
            flex: 1;
        }
    }

    .biz-btn {
        padding: 12px;
        border-radius: 6px;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: block;
        width: 100%;
        box-sizing: border-box;
    }
    .btn-dark {
        background-color: #0F172A;
        color: white;
        border: none;
    }
    .btn-dark:hover {
        background-color: #1e293b;
    }
    .btn-light {
        background-color: white;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }
    .btn-light:hover {
        background-color: #f8fafc;
    }

    /* Sección inferior (2 columnas) */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 40px;
    }
    @media (min-width: 768px) {
        .bottom-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .info-panel {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 25px;
    }
    .info-panel h4 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1rem;
    }
    .check-list-purple .f-item i {
        color: #9333EA; 
    }

    @media (max-width: 900px) {
        .commercial-container { padding: 0 15px; }
        .business-card { padding: 20px; }
    }
    @media (max-width: 600px) {
        .biz-actions { flex-direction: column; }
        .plan-meta { flex-direction: column; gap: 8px; }
        .comm-header { padding: 0 10px; }
        .info-panel { padding: 18px; }
    }
</style>

<div class="commercial-container">

    <div class="comm-header">
        <div class="comm-icon-box">
            <i class="fa-solid fa-building"></i> </div>
        <h2>Internet Comercial</h2>
        <p style="color: #64748B;">Soluciones de conectividad para tu negocio</p>
    </div>

    <div class="business-card">
        <div class="biz-title">Negocio Básico</div>
        <div class="biz-desc">Ideal para oficinas pequeñas (1-5 empleados)</div>

        <div class="biz-price-box">
            <div class="biz-price">$99 <span>por mes</span></div>
            <span class="biz-speed">50 Mbps</span>
        </div>

        <div class="biz-features">
            <h5>Características Incluidas:</h5>
            <div class="feature-grid">
                <div class="f-item"><i class="fa-solid fa-check"></i> Navegación empresarial</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Email corporativo</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Cloud computing</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Videoconferencias</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> IP fija incluida</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> SLA 99.5%</div>
            </div>
        </div>

        <div class="biz-actions">
            <a href="?vista=contratacion&tipo=comercial&plan=negocio_basico" class="biz-btn btn-dark">Contratar Plan</a>
        </div>
    </div>

    <div class="business-card">
        <div class="biz-title">Negocio Plus</div>
        <div class="biz-desc">Ideal para oficinas medianas (5-20 empleados)</div>

        <div class="biz-price-box">
            <div class="biz-price">$199 <span>por mes</span></div>
            <span class="biz-speed">200 Mbps</span>
        </div>

        <div class="biz-features">
            <h5>Características Incluidas:</h5>
            <div class="feature-grid">
                <div class="f-item"><i class="fa-solid fa-check"></i> Todo lo del Plan Básico</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Banda ancha simétrica</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Múltiples IPs fijas</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> VPN corporativa</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Soporte prioritario</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> SLA 99.8%</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Backup automático</div>
            </div>
        </div>

        <div class="biz-actions">
            <a href="?vista=contratacion&tipo=comercial&plan=negocio_plus" class="biz-btn btn-dark">Contratar Plan</a>
        </div>
    </div>

    <div class="business-card">
        <div class="biz-title">Empresarial</div>
        <div class="biz-desc">Ideal para empresas grandes (20+ empleados)</div>

        <div class="biz-price-box">
            <div class="biz-price">$399 <span>por mes</span></div>
            <span class="biz-speed">500 Mbps</span>
        </div>

        <div class="biz-features">
            <h5>Características Incluidas:</h5>
            <div class="feature-grid">
                <div class="f-item"><i class="fa-solid fa-check"></i> Todo lo del Plan Plus</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Fibra óptica dedicada</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Velocidad garantizada</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Gestor de cuenta dedicado</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Instalación premium</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> SLA 99.9%</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Redundancia incluida</div>
            </div>
        </div>

        <div class="biz-actions">
            <a href="?vista=contratacion&tipo=comercial&plan=empresarial" class="biz-btn btn-dark">Contratar Plan</a>
        </div>
    </div>

    <div class="bottom-grid">
        
        <div class="info-panel check-list-purple">
            <h4>Servicios Adicionales</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div class="f-item"><i class="fa-solid fa-check"></i> Hosting y servidores dedicados</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Seguridad perimetral y firewall</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Monitoreo 24/7</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Consultoría técnica</div>
            </div>
        </div>

        <div class="info-panel check-list-purple">
            <h4>¿Por qué elegirnos?</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div class="f-item"><i class="fa-solid fa-check"></i> 15 años de experiencia en el mercado</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Infraestructura de fibra óptica propia</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Soporte técnico local</div>
                <div class="f-item"><i class="fa-solid fa-check"></i> Planes personalizables</div>
            </div>
        </div>

    </div>

</div>
