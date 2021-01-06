<?php include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="nuevo-proyecto" action="#">
        <legend>Nuevo Proyecto</legend>

        <?php include 'inc/templates/formulario.php'; ?>

    </form>
</div>

<?php include 'inc/templates/footer.php'; ?>