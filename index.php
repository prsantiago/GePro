<?php 
    session_start();
    include 'inc/templates/header.php'; 
    if(isset($_GET['cerrar_sesion'])) {
        $_SESSION = array();
}
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra-inicio-sesion">
        <?php include 'inc/templates/logos.php'; ?>

        <div class="login">
            <form id="login" class="caja-login" method="post">
                <div class="campo">
                    <label for="usuario">Correo institucional: </label>
                    <input type="text" name="usuario" id="usuario" placeholder="Correo institucional" required>
                </div>
                <div class="campo">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="campo enviar">
                    <input type="hidden" id="tipo" value="login">
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
        <h1>GePro</h1>
        <h3>Sistema gestor de proyectos</h3>
        <form id="progreso" class="caja-progreso" method="post">
            <div class="campo">
                <label for="clave">Ingrese clave de proyecto: </label>
                <input type="text" name="clave" id="clave" placeholder="" required>
            </div>
            <div class="campo enviar">
                <input type="hidden" id="accion" value="checar">
                <input type="submit" class="boton" value="Ver progreso">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>