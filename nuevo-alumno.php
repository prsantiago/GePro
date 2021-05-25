<!-- Crea una cuenta de alumno hecha por el profesor, -->
<!-- ya que solo se accede a esta página mediante nuevo-proyecto.php -->
<!-- FIXME: Se podría juntar nuevo-alumno.php, crear-cuenta.php y editar-usuario.php -->
<?php session_start(); include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 

        <a href="nuevo-proyecto.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <h1>Crear alumno</h1>
        <form id="alumno" action="#" method="post">
            <legend>Nuevo alumno</legend>

            <!-- Formulario para alumno -->
            <?php include 'inc/templates/formularios/formulario-alumno.php'; ?>

        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>