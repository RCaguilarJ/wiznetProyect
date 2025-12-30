<style>
    .accounts-wrapper { max-width: 1000px; margin: 0 auto; }
    
    .page-header { text-align: center; margin-bottom: 40px; }
    .page-header h2 { margin: 0 0 10px 0; color: #1e293b; font-size: 1.8rem; }
    .page-header p { color: #64748B; margin: 0; }
    
    .alert-box {
        background-color: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 30px;
        text-align: center;
        font-size: 0.9rem;
    }
    .alert-box strong { font-weight: 700; }

    /* Grid de Cuentas */
    .accounts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    /* Tarjeta de Cuenta */
    .account-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .account-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    
    /* Bordes de color */
    .border-bbva { border-top: 4px solid #004481; }
    .border-oxxo { border-top: 4px solid #EAB308; }
    .border-azteca { border-top: 4px solid #10B981; }
    .border-santander { border-top: 4px solid #EC0000; }
    .border-spei { border-top: 4px solid #6366F1; }

    .acc-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    .acc-icon {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        background: #F1F5F9;
        color: #475569;
    }
    .acc-title h3 { margin: 0; font-size: 1.1rem; color: #1e293b; }
    .acc-title span { font-size: 0.8rem; color: #64748B; font-weight: 500; }

    .acc-number-box {
        background-color: #F8FAFC;
        border: 1px dashed #CBD5E1;
        padding: 12px;
        border-radius: 6px;
        text-align: center;
        margin-bottom: 15px;
        position: relative;
    }
    
    .acc-number-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .acc-number {
        font-family: monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        letter-spacing: 1px;
    }
    
    /* Botón de copiar */
    .btn-copy {
        cursor: pointer;
        color: #64748B;
        font-size: 1.1rem;
        transition: color 0.2s, transform 0.1s;
    }
    .btn-copy:hover { color: #3B82F6; }
    .btn-copy:active { transform: scale(0.9); }

    .acc-label {
        display: block;
        font-size: 0.75rem;
        color: #94A3B8;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .acc-owner {
        font-size: 0.85rem;
        color: #475569;
        border-top: 1px solid #f1f5f9;
        padding-top: 10px;
    }
    .acc-owner strong { color: #1e293b; }

    /* Toast de Notificación */
    #copyToast {
        visibility: hidden;
        min-width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 12px;
        position: fixed;
        z-index: 1000;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        opacity: 0;
        transition: opacity 0.3s, bottom 0.3s;
    }
    #copyToast.show {
        visibility: visible;
        opacity: 1;
        bottom: 50px;
    }
    #copyToast i { margin-right: 8px; color: #4ade80; }
</style>

<div class="accounts-wrapper view-shell">

    <div class="page-header">
        <h2>Cuentas Bancarias</h2>
        <p>Realice sus pagos de forma segura</p>
    </div>

    <div class="alert-box">
        <i class="fa-solid fa-triangle-exclamation"></i> <strong>IMPORTANTE:</strong><br>
        En transferencias, agregue su <strong># DE CLIENTE</strong> en el Concepto de Pago.<br>
        En depósitos en efectivo, escriba sus datos en el comprobante (ticket).
    </div>

    <div class="accounts-grid">

        <div class="account-card border-bbva">
            <div class="acc-header">
                <div class="acc-icon" style="color: #004481; background: #e0f2fe;"><i class="fa-solid fa-building-columns"></i></div>
                <div class="acc-title">
                    <h3>BBVA</h3>
                    <span>Efectivo y Traspasos</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number">1596304855</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('1596304855')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Manuel Bedoy Bañuelos</strong>
            </div>
        </div>

        <div class="account-card border-oxxo">
            <div class="acc-header">
                <div class="acc-icon" style="color: #EAB308; background: #FEF9C3;"><i class="fa-solid fa-store"></i></div>
                <div class="acc-title">
                    <h3>OXXO / Santander</h3>
                    <span>Depósitos en Efectivo</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Tarjeta</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number">5579070135353475</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('5579070135353475')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Ana Delia Garcia Salcedo</strong>
            </div>
        </div>

        <div class="account-card border-azteca">
            <div class="acc-header">
                <div class="acc-icon" style="color: #10B981; background: #DCFCE7;"><i class="fa-solid fa-money-bill-transfer"></i></div>
                <div class="acc-title">
                    <h3>Banco Azteca</h3>
                    <span>Efectivo y Traspasos</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number">95461638538216</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('95461638538216')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Manuel Bedoy Bañuelos</strong>
            </div>
        </div>

        <div class="account-card border-santander">
            <div class="acc-header">
                <div class="acc-icon" style="color: #EC0000; background: #FEE2E2;"><i class="fa-solid fa-building-columns"></i></div>
                <div class="acc-title">
                    <h3>Santander</h3>
                    <span>Efectivo y Traspasos</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number">60582459213</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('60582459213')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Ana Delia Garcia Salcedo</strong>
            </div>
        </div>

        <div class="account-card border-oxxo">
            <div class="acc-header">
                <div class="acc-icon" style="color: #9333EA; background: #F3E8FF;"><i class="fa-solid fa-credit-card"></i></div>
                <div class="acc-title">
                    <h3>SPIN by OXXO</h3>
                    <span>Depósitos en Efectivo</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Tarjeta</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number">2242170320722561</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('2242170320722561')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Manuel Bedoy Bañuelos</strong>
            </div>
        </div>

        <div class="account-card border-spei">
            <div class="acc-header">
                <div class="acc-icon" style="color: #6366F1; background: #E0E7FF;"><i class="fa-solid fa-globe"></i></div>
                <div class="acc-title">
                    <h3>SPEI (Interbancario)</h3>
                    <span>Desde cualquier banco</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">CLABE Interbancaria</span>
                <div class="acc-number-wrapper">
                    <div class="acc-number" style="font-size: 0.95rem;">014416605824592135</div>
                    <i class="fa-regular fa-copy btn-copy" onclick="copiarAlPortapapeles('014416605824592135')" title="Copiar"></i>
                </div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Ana Delia Garcia Salcedo</strong>
            </div>
        </div>

    </div>
    
    <div style="text-align: center; margin-top: 40px; font-size: 0.8rem; color: #94A3B8;">
        <p>* Cuentas sujetas a cambio sin previo aviso. Consulte frecuentemente.</p>
    </div>

</div>

<div id="copyToast"><i class="fa-solid fa-circle-check"></i> Copiado al portapapeles</div>

<script>
    function copiarAlPortapapeles(texto) {
        // Usamos la API moderna de portapapeles
        navigator.clipboard.writeText(texto).then(function() {
            mostrarToast();
        }, function(err) {
            console.error('Error al copiar: ', err);
            // Fallback para navegadores viejos (opcional)
            alert("Copiado: " + texto);
        });
    }

    function mostrarToast() {
        var x = document.getElementById("copyToast");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>