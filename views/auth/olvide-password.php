

<h1 class="nombre-pagina">Olvide la Contraseña</h1>
<p class="descripcion-pagina">Restablecer Contraseña</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Tu correo</label>
        <input type="email"
         id="email" 
         name="email"
         placeholder="Ingresa tu correo electrónico"
    >
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión </a>
    <a href="/crear-cuenta ">¿Aun no tienes una cuenta?Crear Cuenta</a>
</div>