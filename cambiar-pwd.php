<?php session_start(); include 'inc/templates/header.php'; ?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
    </div>
</div>


<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!--<p><?php print_r($_SESSION); ?></p>-->
        <p>Ingrese el correo institucional con el que se registró</p>
        <form id="nueva-pwd" class="caja-recuperar" method="post">
            <div class="campo">
                <label for="usuario">Correo institucional: </label>
                <input type="email" name="usuario" id="usuario" placeholder="Correo institucional">
            </div>
            <div class="campo">
                <label for="pwd">Nueva contraseña: </label>
                <input type="password" name="pwd" id="pwd" placeholder="Password">
            </div>
            <div class="campo">
                <label for="val_pwd">Confirmar contraseña: </label>
                <input type="password" name="val_pwd" id="val_pwd" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="cambiar">
                <input type="submit" class="boton" value="Cambiar contraseña">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>