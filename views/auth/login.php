<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina"> Inicia Sesión Con tus Credenciales </p>
 
<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/">
<div class="campo">
        <label for="email">Email</label>
        <input
            type="text"
            id="email"
            name="email"
            placeholder=" Tu E-mail"       
            />
    </div>
    
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder=" Tu Contraseña"
            
            />
    </div>
    <input type="submit" class="boton " value="iniciar sesion"> 
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes cuenta?      Crear Cuenta </a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>