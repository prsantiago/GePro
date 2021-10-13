<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header('Location: index.php?login=false');
}
include 'inc/templates/header.php'; 
// include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

$id_usuario = $_SESSION['id_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
if(!strcmp($tipo_usuario, "alumno")) {
    $stmt = $conn->prepare("SELECT nombre, apellido, matricula, correo, universidad, division, carrera FROM alumno WHERE id = ?");
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $matricula, $correo, $universidad, $division, $carrera);
    $stmt->fetch();
} else if (!strcmp($tipo_usuario, "profesor")) {
    $stmt = $conn->prepare("SELECT nombre, apellido, matricula, correo, universidad, division, departamento FROM profesor WHERE id = ?");
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $matricula, $correo, $universidad, $division, $departamento);
    $stmt->fetch();
}
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?> 

        <?php 
        if(!strcmp($_SESSION['tipo_usuario'], "alumno")) {
        ?>
            <a href="progreso.php?id=<?php echo $_SESSION['id_proyecto'];?>" class="btn volver">Volver</a>
        <?php
        } else if(!strcmp($_SESSION['tipo_usuario'], "profesor")){
        ?>
            <a href="inicio.php" class="btn volver">Volver</a>
        <?php
        }
        ?>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->

        <?php 
        if(!strcmp($_SESSION['tipo_usuario'], "alumno")) {
        ?>
            <h1>Editar alumno</h1>
            <form id="alumno" action="#" method="post">
                <legend>Realiza los cambios que quieras hacer</legend>

                <?php include 'inc/templates/formularios/formulario-alumno.php'; ?>

            </form>
        <?php
        } else if(!strcmp($_SESSION['tipo_usuario'], "profesor")){
        ?>
            <h1>Editar profesor</h1>
            <form id="profesor" class="caja-signup" method="post">
                <legend>Realiza los cambios que quieras hacer</legend>
                
                <?php include 'inc/templates/formularios/formulario-profesor.php'; ?>

            </form>
        <?php
        }
        ?>

        
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>