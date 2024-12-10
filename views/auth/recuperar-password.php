<h1 class="nombre-pagina">Restablecer Contraseña</h1>
<p class="descripcion-pagina">Ingrese tu nueva Contraseña</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
         type="password" name="password"
         id="password"
         placeholder="Tu Nueva Contraseña"
         name="password"
         />
    </div>
    <input type="submit" class="boton" value="Guardar Cambios" >
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión </a>
    <a href="/olvide">¿Aun no tienes cuenta? Crear Cuenta</a>
</div>