

<div class="barra">
    <p>
        <span class="color-hola">Hola:</span> 
        <span class="color-nombre"><?php echo $nombre ?? ''; ?></span>
    </p>
    
    <a class="boton" href="/logout">Cerrar Sesión</a>

</div>

<?php 
if( isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
    <a class="boton"  href="/admin">Ver Citas</a>
    <a class="boton"  href="/servicios">Ver Servicios</a>
    <a class="boton"  href="/servicios/crear">Nuevo Servicio</a>

    </div>
 <?php }
?>