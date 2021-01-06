<?php include 'inc/templates/header.php'; ?>

<div class="contenedor-barra">
    <?php include 'inc/templates/logos.php'; ?>
</div>

<div class="contenedor-formulario">
    <p>Utilice el correo de su institución para crear la cuenta</p>
    <form id="crear-cuenta" class="caja-signup" method="post">
        <div class="campo">
            <label for="usuario">Correo institucional: </label>
            <input type="text" name="usuario" id="usuario" placeholder="Correo institucional">
        </div>
        <div class="campo">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="signup">
            <input type="submit" class="boton" value="Crear cuenta">
        </div>
    </form>
    <div class="opciones">
        <div class="campo">
            <a href="index.php">Inicia sesion</a>
        </div>
    </div>
</div>

<?php include 'inc/templates/footer.php'; ?>