<?php include 'inc/templates/header.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="index.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <h1>Crear cuenta</h1>
        <form id="profesor" class="caja-signup" action="#">
            <legend>Crea una cuenta de profesor con tu correo institucional. <span>Todos los campos son obligatorios</span></legend>
            <div class="campos">
                <div class="campo">
                    <label for="nombre_profesor">Nombre(s): </label>
                    <input type="text" id="nombre_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="apellido_profesor">Apellidos: </label>
                    <input type="text" id="apellido_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="matricula_profesor">Número identificador/Matricula: </label>
                    <input type="text" id="matricula_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="correo_profesor">Correo institucional: </label>
                    <input type="email" id="correo_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="password_profesor">Password: </label>
                    <input type="password" id="password_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="valpass_profesor">Validar password: </label>
                    <input type="password" id="valpass_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="universidad_profesor">Institución a la que perteneces: </label>
                    <input type="text" id="universidad_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="division_profesor">División/Facultad a la que perteneces: </label>
                    <input type="text" id="division_profesor" placeholder="">
                </div>
                <div class="campo">
                    <label for="departamento_profesor">Departamento al que perteneces: </label>
                    <input type="text" id="departamento_profesor" placeholder="">
                </div>
            </div>
            <div class="campo enviar">
                <input type="hidden" id="accion" value="crear">
                <input type="submit" class="boton" value="Crear cuenta">
            </div>
        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>