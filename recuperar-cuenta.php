<?php 
session_start(); 
include 'inc/templates/header.php';
$_SESSION['user'] = $_GET['user'];
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="index.php?login=false" class="btn volver">Volver</a>
    </div>
</div>


<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <br><p>Ingrese el correo institucional con el que se registró</p>
        <form id="recuperar-cuenta" class="caja-recuperar" method="post">
            <div class="campo">
                <label for="usuario">Correo institucional: </label>
                <input type="email" name="usuario" id="usuario" placeholder="Correo institucional">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="recuperar">
                <input type="submit" class="boton" value="Recuperar contraseña">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>