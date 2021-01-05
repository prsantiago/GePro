<?php include 'inc/templates/header.php'; ?>

<div class="contenedor-barra">
    <?php include 'inc/templates/logos.php'; ?>
</div>

<div class="contenedor-formulario">
    <p>Ingrese el correo institucional con el que se registró</p>
    <form id="formulario" class="caja-recuperar" method="post">
        <div class="campo">
            <label for="usuario">Correo institucional: </label>
            <input type="text" name="usuario" id="usuario" placeholder="Correo institucional">
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="recuperar">
            <input type="submit" class="boton" value="Recuperar contraseña">
        </div>
    </form>
</div>

<?php include 'inc/templates/footer.php'; ?>