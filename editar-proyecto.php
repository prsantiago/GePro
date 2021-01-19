<?php include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <form id="editar-proyecto" action="#" method="post">
            <legend>Edite el Proyecto</legend>

            <?php include 'inc/templates/formularios/formulario-proyecto.php'; ?>

        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>