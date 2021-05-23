<?php session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
$id_seguimiento = $_SESSION['id_seguimiento'];
$id_proyecto = $_SESSION['id_proyecto'];
$etapa = $_GET['etapa'];
$actividad = $_GET['actividad'];
$_SESSION['id_etapa']=$etapa;
$_SESSION['id_actividad']=$actividad;
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="progreso.php?id= <?php echo $id_proyecto; ?>" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!--<p><?php print_r($_SESSION); ?></p>-->
        <h1>Comentarios</h1>
        <div class="comentarios">
            <?php 
            if($actividad != 3){
                $comentarios = obtenerComentariosActividad($id_proyecto, $etapa, $actividad);
                if($comentarios->num_rows) {
                    foreach($comentarios as $comentario) { 
                ?>
                        <div class="comentario">
                            <p class="com_nombre"><?php echo $comentario['nombre']." ".$comentario['apellido'] ?> </p>
                            <p class="com_fecha">&ensp;[<?php echo $comentario['fecha'];?>]</p> 
                            <p class="com_com"><?php echo $comentario['comentario']?></p>
                        </div>
                <?php   
                    } 
                } 
            }
            else {
                $comentarios = obtenerComentariosEtapa($id_proyecto, $etapa);
                if($comentarios->num_rows) {
                    foreach($comentarios as $comentario) {
                    ?>
                    <div class="comentario">
                            <!-- <p class="com_nombre"><?php echo $comentario['nom_usuario']." ".$comentario['apellido']?>
                            <p class="com_fecha">&ensp;[<?php echo $comentario['fecha']?>]</p> -->
                            <p class="com_nombre"><?php echo $comentario['nombre']." ".$comentario['apellido']?>
                            <p class="com_fecha">&ensp;[<?php echo $comentario['fecha']?>]</p> </p>
                            <p class="com_com"><?php echo $comentario['comentario']?></p>
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