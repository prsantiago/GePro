<!-- Landing page del sistema Deni -->
<!-- Muestra un area para que SOLO el profesor inicie sesión, , cree su cuenta y recupere su contraseña -->
<!-- El contenido de <main> es SOLO para el alumno, al ingresar la clave de su proyecto lo manda al progreso de este -->
<?php 
session_start();
include 'inc/templates/header.php'; 

// Si 'login' cambió a false, se borrán las variables de sesión ya que el usuario cerró sesión
if(isset($_GET['login'])) {
    if(!strcmp($_GET['login'], 'false')) {
        $_SESSION = array();
    }
}

include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

// FIXME: Mala práctica (se hizo ya que se estaban teniendo problemas para hacer una función general)
// Query para obtener número de proyectos que se han creado 
$stmtproyectos = $conn->prepare("SELECT MAX(id) FROM proyecto_vigente");
$stmtproyectos->execute();
$stmtproyectos->bind_result($proyectos);
$stmtproyectos->fetch();
$stmtproyectos->close();
// Query para obtener número de profesores que se han creado
$stmtprofesores = $conn->prepare("SELECT MAX(id) FROM profesor");
$stmtprofesores->execute();
$stmtprofesores->bind_result($profesores);
$stmtprofesores->fetch();
$stmtprofesores->close();
// Query para obtener número de alumnos que se han creado
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
                    <a class="vinculo" href="crear-cuenta.php">Crea cuenta nueva de profesor</a>
                </div>
                <div class="campo">
                    <a class="vinculo" href="recuperar-cuenta.php?user=prof">Recuperar contraseña</a>
                </div>
            </div> 
        </div>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="contenedor bg-terciario contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <!-- Métricas del uso del sistema, número de proyectos y usuarios (profesores y alumnos)  -->
        <p> <b><?php if($proyectos==null) echo 0; else echo $proyectos;?> Proyectos</b></p>
        <p> <b><?php echo $profesores + $alumnos?> Usuarios</b></p>
        <h1>Dëni</h1>
        <h3>Seguimiento de proyectos</h3>
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