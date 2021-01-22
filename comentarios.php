<?php session_start(); include 'inc/templates/header.php'; ?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="progreso.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <div class="comentarios">
            <div class="comentario bg-cuaternario">
                <p>comentario 1 del alumno</p>
            </div>
            <div class="comentario bg-cuaternario">
                <p>comentario 1 del profesor</p>
            </div>
            <div class="comentario bg-cuaternario">
                <p>comentario 2 del alumno</p>
            </div>
            <div class="comentario bg-cuaternario">
                <p>comentario 2 del profesor</p>
            </div>
        </div>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>