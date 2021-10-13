<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header('Location: index.php?login=false');
}
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

$id_proyecto = $_GET['id'];
// $stmt = $conn->prepare("SELECT * FROM proyecto_vigente WHERE id = ?");
$stmt = $conn->prepare("SELECT id_asesor2, id_alumno, proyecto, fechaInicio, descripcion FROM proyecto_vigente WHERE id = ?");
$stmt->bind_param('i', $id_proyecto);
$stmt->execute();
// $stmt->bind_result($idProy,$id_asesor,$id_coasesor, $id_alumno, $nombre, $fechaInicio, $fechaFin, $descripcion, $comentario, $clave);
$stmt->bind_result($id_coasesor, $id_alumno, $nombre, $fecha, $descripcion);
$stmt->fetch();
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <form id="proyecto" action="#" method="post">
            <legend>Edite el Proyecto</legend>
            <?php include 'inc/templates/formularios/formulario-proyecto.php'; ?>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>