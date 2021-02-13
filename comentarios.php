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
        <h1>Comentarios</h1>
        <div class="comentarios">
            <?php 
            $comentarios = obtenerComentarios($_SESSION['id_seguimiento']);
            if($comentarios->num_rows) {
                foreach($comentarios as $comentario) { 
            ?>
                    <div class="comentario bg-cuaternario">>
                        <p><?php echo $comentario['nombre']." ".$comentario['apellido']?></p>
                        <p><?php echo $comentario['fecha']?></p>
                        <p><?php echo $comentario['comentario']?></p>
                    </div>
            <?php   
                } 
            } 
            ?>
        </div>

        <form id="comentario" action="#" method="post">
            <legend>Nuevo comentario</legend>

            <?php include 'inc/templates/formularios/formulario-comentario.php'; ?>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>