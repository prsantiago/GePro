<?php include 'inc/templates/header.php'; ?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="index.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <h1>Crear cuenta</h1>
        <form id="crear-cuenta" class="caja-signup" action="#">
            <legend>Crea una cuenta de profesor con tu correo institucional. <span>Todos los campos son obligatorios</span></legend>
            <div class="campos">
                <div class="campo">
                    <label for="nombre">Nombre(s): </label>
                    <input type="text" name="nombre" id="nombre" placeholder="">
                </div>
                <div class="campo">
                    <label for="apellido">Apellidos: </label>
                    <input type="text" name="apellido" id="apellido" placeholder="">
                </div>
                <div class="campo">
                    <label for="matricula">Número identificador/Matricula: </label>
                    <input type="text" name="matricula" id="matricula" placeholder="">
                </div>
                <div class="campo">
                    <label for="correo">Correo institucional: </label>
                    <input type="email" name="correo" id="correo" placeholder="">
                </div>
                <div class="campo">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" placeholder="">
                </div>
                <div class="campo">
                    <label for="valpass">Validar password: </label>
                    <input type="password" name="valpass" id="valpass" placeholder="">
                </div>
                <div class="campo">
                    <label for="institucion">Institución a la que perteneces: </label>
                    <input type="text" name="institucion" id="institucion" placeholder="">
                </div>
                <div class="campo">
                    <label for="division">División/Facultad a la que perteneces: </label>
                    <input type="text" name="division" id="division" placeholder="">
                </div>
                <div class="campo">
                    <label for="carrera">Departamento al que perteneces: </label>
                    <input type="text" name="carrera" id="carrera" placeholder="">
                </div>
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="signup">
                <input type="submit" class="boton" value="Crear cuenta">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>