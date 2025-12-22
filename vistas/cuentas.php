<style>
    /* Estilos específicos para esta vista */
    .bank-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        transition: box-shadow 0.2s;
    }
    .bank-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    /* Header de la tarjeta (Icono + Nombres) */
    .bank-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .bank-icon-box {
        width: 48px;
        height: 48px;
        background-color: #DBEAFE; /* Azul muy claro */
        color: #2563EB; /* Azul fuerte */
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .bank-title h3 {
        margin: 0;
        font-size: 1rem;
        color: #1e293b;
    }
    .bank-title span {
        font-size: 0.85rem;
        color: #64748B;
    }

    /* Detalles de la cuenta */
    .account-detail {
        margin-bottom: 15px;
    }
    .detail-label {
        display: block;
        font-size: 0.75rem;
        color: #64748B;
        margin-bottom: 4px;
    }
    .detail-value {
        font-size: 1rem;
        color: #0f172a;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .account-number {
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.5px;
    }
    .copy-btn {
        cursor: pointer;
        color: #64748B;
        transition: color 0.2s;
    }
    .copy-btn:hover {
        color: #2563EB;
    }
    .copy-btn.copied {
        color: #2563EB;
    }
    .copy-toast {
        position: fixed;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #0F172A;
        color: #fff;
        padding: 12px 18px;
        border-radius: 999px;
        font-size: 0.9rem;
        box-shadow: 0 10px 25px rgba(15,23,42,0.25);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 9999;
    }
    .copy-toast.visible {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* Cuadro de instrucciones inferior */
    .info-box {
        background-color: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 8px;
        padding: 20px;
        color: #1E40AF;
    }
    .info-box h4 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .info-box ul {
        margin: 0;
        padding-left: 20px;
        font-size: 0.85rem;
        line-height: 1.6;
    }
    @media (max-width: 900px) {
        .bank-card { padding: 20px; }
    }
    @media (max-width: 600px) {
        .bank-header { flex-direction: column; align-items: flex-start; }
        .detail-value { flex-wrap: wrap; }
        .info-box { padding: 15px; }
    }
</style>

<div class="bank-wrapper view-shell">

<div style="margin-bottom: 30px;">
    <h2 style="margin: 0; font-size: 1.5rem;">Cuentas Bancarias</h2>
    <p style="color: #64748B; margin-top: 5px;">Información de las cuentas bancarias para realizar pagos</p>
</div>

<div class="bank-card">
    <div class="bank-header">
        <div class="bank-icon-box">
            <i class="fa-solid fa-building-columns"></i>
        </div>
        <div class="bank-title">
            <h3>Banco Nacional</h3>
            <span>Cuenta Corriente</span>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Número de Cuenta</span>
        <div class="detail-value">
            <span class="account-number">0001-0234-5678-9012</span> 
            <i class="fa-regular fa-copy copy-btn" data-copy="0001-0234-5678-9012" title="Copiar número"></i>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Titular</span>
        <div class="detail-value">Wiznet S.A.</div>
    </div>

    <div class="account-detail" style="margin-bottom: 0;">
        <span class="detail-label">Moneda</span>
        <div class="detail-value">USD</div>
    </div>
</div>

<div class="bank-card">
    <div class="bank-header">
        <div class="bank-icon-box">
            <i class="fa-solid fa-building-columns"></i>
        </div>
        <div class="bank-title">
            <h3>Banco Internacional</h3>
            <span>Cuenta de Ahorros</span>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Número de Cuenta</span>
        <div class="detail-value">
            <span class="account-number">1234-5678-9012-3456</span>
            <i class="fa-regular fa-copy copy-btn" data-copy="1234-5678-9012-3456" title="Copiar número"></i>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Titular</span>
        <div class="detail-value">Wiznet S.A.</div>
    </div>

    <div class="account-detail" style="margin-bottom: 0;">
        <span class="detail-label">Moneda</span>
        <div class="detail-value">USD</div>
    </div>
</div>

<div class="bank-card">
    <div class="bank-header">
        <div class="bank-icon-box">
            <i class="fa-solid fa-building-columns"></i>
        </div>
        <div class="bank-title">
            <h3>Banco Central</h3>
            <span>Cuenta Corriente</span>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Número de Cuenta</span>
        <div class="detail-value">
            <span class="account-number">9876-5432-1098-7654</span>
            <i class="fa-regular fa-copy copy-btn" data-copy="9876-5432-1098-7654" title="Copiar número"></i>
        </div>
    </div>

    <div class="account-detail">
        <span class="detail-label">Titular</span>
        <div class="detail-value">Wiznet S.A.</div>
    </div>

    <div class="account-detail" style="margin-bottom: 0;">
        <span class="detail-label">Moneda</span>
        <div class="detail-value">Colones</div>
    </div>
</div>

<div class="info-box">
    <h4>Instrucciones para Pago</h4>
    <ul>
        <li>Realice la transferencia o depósito a cualquiera de nuestras cuentas</li>
        <li>Conserve el comprobante de pago</li>
        <li>Reporte su pago en la sección "Reportar Pago" con el número de referencia</li>
        <li>Su servicio será activado en un máximo de 24 horas hábiles</li>
    </ul>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyButtons = document.querySelectorAll('.copy-btn');
    const toast = document.createElement('div');
    toast.className = 'copy-toast';
    toast.textContent = 'Número copiado al portapapeles';
    document.body.appendChild(toast);

    const showToast = () => {
        toast.classList.add('visible');
        clearTimeout(showToast.timeoutId);
        showToast.timeoutId = setTimeout(() => toast.classList.remove('visible'), 1800);
    };

    copyButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            const value = btn.dataset.copy || btn.closest('.detail-value')?.querySelector('.account-number')?.textContent.trim();
            if (!value) return;

            try {
                await navigator.clipboard.writeText(value);
                btn.classList.add('copied');
                const prevTitle = btn.title;
                btn.title = 'Copiado';
                showToast();
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btn.title = prevTitle || 'Copiar número';
                }, 1500);
            } catch (error) {
                console.error('No se pudo copiar el número de cuenta', error);
            }
        });
    });
});
</script>
