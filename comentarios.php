<?php session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
$id_seguimiento = $_SESSION['id_seguimiento'];
$id_proyecto = $_SESSION['id_proyecto'];
$id_etapa = $_SESSION['id_entrega'];
$id_actividad = $_SESSION['id_proceso'];
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="progreso.php?id= <?php echo $id_proyecto; ?>" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <h1>Comentarios</h1>
        <div class="comentarios">
            <?php 
            if (!strcmp($_GET['tipo'], 'etapa')) {
                $comentarios = obtenerComentariosEtapa($id_seguimiento, $id_etapa);
                // $comentarios = obtenerComentarios(1);
                if($comentarios->num_rows) {
                    foreach($comentarios as $comentario) { 
            ?>
                        <div class="comentario">
                            <p><?php echo $comentario['nombre']." ".$comentario['apellido']?></p>
                            <p><?php echo $comentario['fecha']?></p>
                            <p><?php echo $comentario['comentario']?></p>
                        </div>
            <?php
                    }   
                } 
            } else if (!strcmp($_GET['tipo'], 'actividad')) {
                $comentarios = obtenerComentariosActividad($id_seguimiento, $id_etapa, $id_actividad);
                // $comentarios = obtenerComentarios(1);
                if($comentarios->num_rows) {
                    foreach($comentarios as $comentario) { 
            ?>
                        <div class="comentario">
                            <p><?php echo $comentario['nombre']." ".$comentario['apellido']?></p>
                            <p><?php echo $comentario['fecha']?></p>
                            <p><?php echo $comentario['comentario']?></p>
                        </div>
            <?php
                    }   
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