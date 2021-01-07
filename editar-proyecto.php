<?php include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>

<div class="bg-secundario">
    <div class="bg-terciario contenedor sombra">
        <form id="editar-proyecto" action="#">
            <legend>Edite el Proyecto</legend>

            <?php include 'inc/templates/formulario.php'; ?>

        </form>
    </div>
</div>

<?php include 'inc/templates/footer.php'; ?>