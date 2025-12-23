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
    
    /* Borde superior de color por tipo */
    .border-bbva { border-top: 4px solid #004481; }
    .border-oxxo { border-top: 4px solid #EAB308; } /* Amarillo Oxxo */
    .border-azteca { border-top: 4px solid #10B981; } /* Verde */
    .border-santander { border-top: 4px solid #EC0000; } /* Rojo */
    .border-spei { border-top: 4px solid #6366F1; } /* Morado SPEI */

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
    }
    .acc-number {
        font-family: monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        letter-spacing: 1px;
    }
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

    .whatsapp-btn {
        display: block;
        background-color: #25D366;
        color: white;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 40px;
        transition: background 0.2s;
    }
    .whatsapp-btn:hover { background-color: #1ebc57; }
</style>

<div class="accounts-wrapper view-shell">

    <div class="page-header">
        <h2>Cuentas Bancarias</h2>
        <p>Realice sus pagos de forma segura en las siguientes cuentas</p>
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
                    <span>Efectivo y Traspasos (Mismo Banco)</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number">159-630-4855</div>
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
                <div class="acc-number">5579-0701-3535-3475</div>
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
                    <span>Efectivo y Traspasos (Mismo Banco)</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number">9546-1638-5382-16</div>
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
                    <span>Efectivo y Traspasos (Mismo Banco)</span>
                </div>
            </div>
            <div class="acc-number-box">
                <span class="acc-label">Número de Cuenta</span>
                <div class="acc-number">60582459213</div>
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
                <div class="acc-number">2242-1703-2072-2561</div>
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
                <div class="acc-number" style="font-size: 1rem;">0144-1660-5824-5921-35</div>
            </div>
            <div class="acc-owner">
                Titular: <strong>Ana Delia Garcia Salcedo</strong>
            </div>
        </div>

    </div>

    <a href="https://wa.me/523318333058?text=Hola,%20adjunto%20mi%20comprobante%20de%20pago." target="_blank" class="whatsapp-btn">
        <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem; margin-right: 5px;"></i>
        Enviar Comprobante por WhatsApp (33 1833 3058)
    </a>
    
    <div style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: #94A3B8;">
        <p>* Cuentas sujetas a cambio sin previo aviso. Consulte frecuentemente.</p>
    </div>

</div>