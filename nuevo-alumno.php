<?php include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 

        <a href="nuevo-proyecto.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <h1>Crear alumno</h1>
        <form id="alumno" action="#" method="post">
            <legend>Nuevo alumno</legend>

            <?php include 'inc/templates/formularios/formulario-alumno.php'; ?>

        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>