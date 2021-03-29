<?php 
session_start();
include 'inc/templates/header.php'; 
if(isset($_GET['login'])) {
    if(!strcmp($_GET['login'], 'false')) {
        $_SESSION = array();
    }
}

include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

// function conteo($nombre_tabla) {
//     $stmt = $conn->prepare("SELECT MAX(id) FROM ?");
//     $stmt->bind_param('s', $nombre_tabla);
//     $stmt->execute();
//     $stmt->bind_result($resultado);
//     $stmt->fetch();
//     $stmt->close();
//     $conn->close();
//     return $resultado;
// }

$stmtprofesores = $conn->prepare("SELECT MAX(id) FROM proyecto_vigente");
$stmtprofesores->execute();
$stmtprofesores->bind_result($proyectos);
$stmtprofesores->fetch();
$stmtprofesores->close();

$stmtprofesores = $conn->prepare("SELECT MAX(id) FROM profesor");
$stmtprofesores->execute();
$stmtprofesores->bind_result($profesores);
$stmtprofesores->fetch();
$stmtprofesores->close();

$stmtalumnos = $conn->prepare("SELECT MAX(id) FROM alumno");
$stmtalumnos->execute();
$stmtalumnos->bind_result($alumnos);
$stmtalumnos->fetch();
$stmtalumnos->close();
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra-inicio-sesion">
        <?php include 'inc/templates/logos.php'; ?>

        <div class="login">
            <form id="login-profesor" class="caja-login" method="post">
                <div class="campo">
                    <label for="usuario">Correo institucional: </label>
                    <input type="text" name="usuario" id="usuario" placeholder="Correo institucional" required>
                </div>
                <div class="campo">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="campo enviar">
                    <input name="tipo" type="hidden" id="tipo" value="login">
                    <input type="submit" class="boton" value="Iniciar sesión">
                </div>
            </form>
            <div class="opciones-login">
                <div class="campo">
                    <a href="crear-cuenta.php">Crea una cuenta de profesor nueva</a>
                </div>
                <div class="campo">
                    <a href="recuperar-cuenta.php">Recuperar contraseña</a>
                </div>
            </div> 
        </div>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="contenedor bg-terciario contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <p> <?php echo $proyectos?> Proyectos</p>
        <p> <?php echo $profesores + $alumnos?> Usuarios</p>
        <h1>GePro</h1>
        <h3>Sistema gestor de proyectos</h3>
        <form id="progreso" class="caja-progreso" method="post">
            <div class="campo">
                <label for="clave">Ingrese clave de proyecto: </label>
                <input type="text" name="clave" id="clave" placeholder="" required>
            </div>
            <div class="campo enviar">
                <input name="accion" type="hidden" id="accion" value="checar">
                <input type="submit" class="boton" value="Ver progreso">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>