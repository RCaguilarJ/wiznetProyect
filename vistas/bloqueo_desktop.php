<?php
// Archivo: vistas/bloqueo_desktop.php
?>

<style>
   
    #contenido-principal-app {
        display: block !important;
    }
    
    #contenedor-desktop-externo {
        display: none !important;
    }

    
    @media only screen and (min-width: 1025px) {
        
       
        #contenido-principal-app {
            display: none !important;
        }

       
        #contenedor-desktop-externo {
            display: block !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;     
            height: 100vh;    
            border: none;
            z-index: 99999;   
            background: white;
        }
    }
</style>

<iframe id="contenedor-desktop-externo" src="https://wiznet.mx/"></iframe>