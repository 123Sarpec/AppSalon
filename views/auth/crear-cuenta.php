<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llenar datos, para crear la cuenta</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder=" Tu nombre" 
            value="<?php echo s($usuario->nombre); ?>"
            />
            
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder=" Tu apellido" 
            value="<?php echo s($usuario->apellido); ?>"

            />
    </div>

    
    <div class="campo">
        <label for="tel">Telefono</label>
        <input
            type="text"
            id="telefono"
            name="telefono"
            placeholder=" Tu No.Telefono" 
            value="<?php echo s($usuario->telefono); ?>"

            />
    </div>

    
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="text"
            id="email"
            name="email"
            placeholder=" Tu E-mail"
            value="<?php echo s($usuario->email); ?>"

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

    <input type="submit" value="Crear Cuenta" class="boton">
    
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Inicia Sesión </a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>