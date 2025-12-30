<style>
    /* Por defecto (PC): El contenido de la app se oculta */
    #contenido-principal-app {
        display: none !important;
    }

    /* Por defecto (PC): El mensaje de bloqueo se muestra */
    #aviso-solo-movil {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
        background-color: #0f172a; /* Color de fondo oscuro */
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999; /* Para que quede encima de todo */
        color: white;
        text-align: center;
        font-family: Arial, sans-serif;
    }

    /* --- LA MAGIA: MEDIA QUERY --- */
    /* Si la pantalla es menor a 1024px (Tablets y Celulares) */
    @media only screen and (max-width: 1024px) {
        
        /* Ocultamos el aviso */
        #aviso-solo-movil {
            display: none !important;
        }

        /* Mostramos la App */
        #contenido-principal-app {
            display: block !important; /* O flex, o grid, según uses */
        }
    }
</style>

<div id="aviso-solo-movil">
    <div style="padding: 20px;">
        <h1 style="font-size: 3rem;">📱</h1>
        <h2>Versión Móvil</h2>
        <p>Esta aplicación solo está disponible en dispositivos móviles y tablets.</p>
        <p style="color: #94a3b8; font-size: 0.9rem;">Por favor, reduce el tamaño de tu ventana o entra desde tu celular.</p>
    </div>
</div>