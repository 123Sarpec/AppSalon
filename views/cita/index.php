


<?php
//  include_once __DIR__ . '/../templates/barra.php';
?>

<h1 class="nombre-pagina">Crear nueva Cita</h1>
<p class="descripcion-pagina">Selecciona tus servicios que desea, e ingrese sus datos</p>


<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Ingrese tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    type="text"
                    placeholder="Tu nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    id="fecha"
                    type="date"
                    min="2024-11-11"
                    min="<?php echo date('Y-m-d'); ?>"
                />
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time"
                />
            </div>
            <input  type="hidden" id="id" value=" <?php echo $id; ?>">
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Valida que tu información esté correcta</p>
    </div>

    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
            type="button"
        >&laquo; Anterior</button>

        <button
            id="siguiente"
            class="boton"
            type="button"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
    ";
?>
