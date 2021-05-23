<!-- Nuevo proyecto creado por el profesor -->
<!-- FIXME: Se podría juntar nuevo.proyecto.php y editar-proyecto.php -->
<?php 
session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a class="vinculo" href="nuevo-alumno.php">Nuevo alumno</a>
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <form id="proyecto" action="#" method="post">
            <legend>Nuevo Proyecto</legend>

            <!-- Formulario para proyecto -->
            <?php include 'inc/templates/formularios/formulario-proyecto.php'; ?>

        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>