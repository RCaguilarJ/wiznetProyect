<style>
    /* Wrapper general */
    .contact-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Cabecera */
    .page-header { margin-bottom: 25px; }
    .page-header h2 { margin: 0 0 5px 0; color: #1e293b; }
    .page-header p { margin: 0; color: #64748B; font-size: 0.95rem; }

    /* Estilo Base de Tarjetas */
    .card-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .section-title {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        margin-top: 0;
        margin-bottom: 20px;
    }

    /* --- FORMULARIO --- */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .full-width { grid-column: span 2; }

    .form-group { display: flex; flex-direction: column; }
    .form-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .form-control {
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 0.9rem;
        color: #334155;
        width: 100%;
        box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #3B82F6; background-color: white; }
    .form-control::placeholder { color: #94A3B8; }

    /* Botones */
    .btn-row { display: flex; gap: 15px; margin-top: 10px; }
    .btn-dark {
        background-color: #0F172A; color: white; border: none; padding: 12px 30px;
        border-radius: 6px; font-weight: 600; cursor: pointer; flex: 1;
    }
    .btn-light {
        background-color: white; border: 1px solid #e2e8f0; color: #333;
        padding: 12px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;
    }

    
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) {
        .info-grid { grid-template-columns: 1fr; } 
    }

    /* Items de contacto (Iconos + Texto) */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }
    .icon-box {
        width: 35px;
        height: 35px;
        border-radius: 8px; /* Cuadrado redondeado */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    /* Colores específicos para los iconos */
    .bg-blue { background-color: #DBEAFE; color: #2563EB; }
    .bg-green { background-color: #DCFCE7; color: #16A34A; }
    .bg-purple { background-color: #F3E8FF; color: #9333EA; }
    .bg-orange { background-color: #FFEDD5; color: #EA580C; }

    .info-text h5 { margin: 0 0 5px 0; font-size: 0.85rem; color: #64748B; font-weight: normal; }
    .info-text p { margin: 0; font-size: 0.95rem; color: #1e293b; font-weight: 500; }
    .small-note { font-size: 0.75rem; color: #94A3B8; margin-top: 2px; }

    /* Horarios */
    .schedule-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .clock-icon { color: #2563EB; margin-top: 3px; }
    .schedule-text h5 { margin: 0 0 5px 0; font-size: 0.9rem; color: #333; }
    .schedule-text p { margin: 0; font-size: 0.85rem; color: #64748B; }

    /* Badge verde de soporte */
    .support-badge {
        background-color: #F0FDF4;
        color: #166534;
        padding: 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        text-align: center;
        margin-top: 20px;
        font-weight: 500;
    }

    /* Botones sociales */
    .social-btn {
        display: block;
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 10px;
        color: #1e293b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        background: white;
        transition: background 0.2s;
        box-sizing: border-box;
    }
    .social-btn:hover { background-color: #f8fafc; }
    .social-btn span { font-weight: 600; }

    @media (max-width: 900px) {
        .contact-wrapper { padding: 0 15px; }
        .card-box { padding: 20px; }
    }
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .full-width { grid-column: span 1; }
        .btn-row { flex-direction: column; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="contact-wrapper view-shell">

    <div class="page-header">
        <h2>Contacto</h2>
        <p>¿Tiene alguna pregunta? Contáctenos y le responderemos a la brevedad</p>
    </div>

    <div class="card-box">
        <h3 class="section-title">Envíanos un Mensaje</h3>
        
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre Completo *</label>
                    <input type="text" class="form-control" placeholder="Juan Pérez" value="Juan Pérez">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico *</label>
                    <input type="email" class="form-control" placeholder="juan@ejemplo.com" value="juan@ejemplo.com">
                </div>

                <div class="form-group">
                    <label>Teléfono *</label>
                    <input type="tel" class="form-control" placeholder="8888-8888" value="8888-8888">
                </div>
                <div class="form-group">
                    <label>Prefiere ser contactado por *</label>
                    <select class="form-control">
                        <option>Seleccione una opción</option>
                        <option>Correo Electrónico</option>
                        <option>Teléfono</option>
                        <option>WhatsApp</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Asunto *</label>
                    <input type="text" class="form-control" placeholder="¿En qué podemos ayudarle?">
                </div>

                <div class="form-group full-width">
                    <label>Mensaje *</label>
                    <textarea class="form-control" rows="4" placeholder="Escriba su mensaje aquí..."></textarea>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-dark">Enviar Mensaje</button>
                <button type="reset" class="btn-light">Limpiar</button>
            </div>
            
            <p style="font-size: 0.75rem; color: #64748B; margin-top: 15px;">
                * Campos requeridos. Nos comprometemos a responder en un plazo máximo de 24 horas.
            </p>
        </form>
    </div>

    <div class="info-grid">

        <div class="card-box" style="margin-bottom: 0;">
            <h3 class="section-title">Información de Contacto</h3>
            
            <div class="info-item">
                <div class="icon-box bg-blue"><i class="fa-solid fa-phone"></i></div>
                <div class="info-text">
                    <h5>Teléfono</h5>
                    <p>2222-2222</p>
                    <div class="small-note">Lunes a Domingo</div>
                </div>
            </div>

            <div class="info-item">
                <div class="icon-box bg-green"><i class="fa-brands fa-whatsapp"></i></div>
                <div class="info-text">
                    <h5>WhatsApp</h5>
                    <p>8888-8888</p>
                    <div class="small-note">24/7</div>
                </div>
            </div>

            <div class="info-item">
                <div class="icon-box bg-purple"><i class="fa-regular fa-envelope"></i></div>
                <div class="info-text">
                    <h5>Email</h5>
                    <p>info@wiznet.com</p>
                    <div class="small-note">Respuesta en 24h</div>
                </div>
            </div>

            <div class="info-item" style="margin-bottom: 0;">
                <div class="icon-box bg-orange"><i class="fa-solid fa-location-dot"></i></div>
                <div class="info-text">
                    <h5>Dirección</h5>
                    <p>Av. Principal #123</p>
                    <div class="small-note">San José, Costa Rica</div>
                </div>
            </div>
        </div>

        <div class="card-box" style="margin-bottom: 0;">
            <h3 class="section-title">Horarios de Atención</h3>
            
            <div class="schedule-item">
                <i class="fa-regular fa-clock clock-icon"></i>
                <div class="schedule-text">
                    <h5>Lunes a Viernes</h5>
                    <p>8:00 AM - 8:00 PM</p>
                </div>
            </div>

            <div class="schedule-item">
                <i class="fa-regular fa-clock clock-icon"></i>
                <div class="schedule-text">
                    <h5>Sábados</h5>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
            </div>

            <div class="schedule-item">
                <i class="fa-regular fa-clock clock-icon"></i>
                <div class="schedule-text">
                    <h5>Domingos</h5>
                    <p>10:00 AM - 2:00 PM</p>
                </div>
            </div>

            <div class="support-badge">
                Soporte técnico disponible 24/7
            </div>
        </div>

        <div class="card-box" style="margin-bottom: 0;">
            <h3 class="section-title">Síguenos</h3>
            
            <a href="#" class="social-btn">
                Facebook: <span>@WiznetCR</span>
            </a>
            
            <a href="#" class="social-btn">
                Instagram: <span>@wiznet_cr</span>
            </a>
            
            <a href="#" class="social-btn">
                Twitter: <span>@WiznetCR</span>
            </a>
        </div>

    </div>

</div>
