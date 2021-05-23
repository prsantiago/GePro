<?php session_start(); include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a href="historial.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <form id="editar-seguimiento" action="#" method="post">
            <legend>Edite el Seguimiento</legend>

            <input name="fecha_entrega" type="date">
            <input name="accion" type="hidden" value="editar">
            <input name="id_seguimiento" type="hidden" value="<?php echo $_GET['id']?>">
            <input type="submit" class="boton" value="Cambiar entrega">
                
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>