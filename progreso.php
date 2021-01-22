<?php session_start(); include 'inc/templates/header.php'; ?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <?php if ($_SESSION['tipo_usuario'] == 'profesor') { ?>
            <a href="inicio.php" class="btn volver">Volver</a>
        <?php } else if ($_SESSION['tipo_usuario'] == 'alumno') { ?>
            <a href="index.php?login=false">Cerrar Sesión</a>
        <?php } else { ?>
            <div class="login">
                <form id="login-alumno" class="caja-login" method="post">
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
                        <a href="recuperar-cuenta.php">Recuperar contraseña</a>
                    </div>
                </div> 
            </div>
        <?php } ?>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <h1>Progreso del proyecto</h1>
        <div class="entregas">
            <div class="entrega bg-cuaternario">
                <p>Introducción</p>
                <?php if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php" class="btn">dd/mm/aaaa</a>
                <?php } else { ?>
                    <p>dd/mm/aaaa</p>
                <?php } ?>
            </div>
            <div class="entrega bg-cuaternario">
                <p>Marco teórico</p>
                <?php if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php" class="btn">en proceso</a>
                <?php } else { ?>
                    <p>en proceso</p>
                <?php } ?>
            </div>
            <div class="entrega">
                <p>Desarrollo</p>
                <!-- <a href="comentarios.php" class="btn">dd/mm/aaaa</a> -->
            </div>
            <div class="entrega">
                <p>Resultados</p>
                <!-- <a href="comentarios.php" class="btn">dd/mm/aaaa</a> -->
            </div>
            <div class="entrega">
                <p>Tesis integrada</p>
                <!-- <a href="comentarios.php" class="btn">dd/mm/aaaa</a> -->
            </div>
        </div>
        <div class="confirmar-entrega">
            <form id="entrega" action="#" method="post">
                <input type="date" name="fecha-entrega" id="fecha-entrega">
                <input type="submit" class="boton" value="Confirmar entrega">
            </form>
        </div>

        <div class="procesos">
            <div class="proceso bg-cuaternario">
                <p>Entrega</p>
                <?php if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php" class="btn">dd/mm/aaaa</a>
                <?php } else { ?>
                    <p>dd/mm/aaaa</p>
                <?php } ?>
            </div>
            <div class="proceso bg-cuaternario">
                <p>Retroalimentación</p>
                <?php if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php" class="btn">dd/mm/aaaa</a>
                <?php } else { ?>
                    <p>dd/mm/aaaa</p>
                <?php } ?>
            </div>
            <div class="proceso bg-cuaternario">
                <p>Aprobación</p>
                <?php if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php" class="btn">en proceso</a>
                <?php } else { ?>
                    <p>en proceso</p>
                <?php } ?>
            </div>
            <div class="proceso">
                <p>Presentación</p>
                <!-- <a href="comentarios.php" class="btn">dd/mm/aaaa</a> -->
            </div>
        </div>
        <div class="confirmar-proceso">
            <form id="proceso" action="#" method="post">
                <input type="date" name="fecha-proceso" id="fecha-proceso">
                <input type="submit" class="boton" value="Confirmar entrega">
            </form>
        </div>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>