<?php session_start(); include 'inc/templates/header.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        
        <a href="index.php" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <h1>Crear cuenta</h1>
        <form id="profesor" class="caja-signup" method="post">
            <legend>Crea una cuenta de profesor con tu correo institucional. <span>Todos los campos son obligatorios</span></legend>
            
            <?php include 'inc/templates/formularios/formulario-profesor.php'; ?>

        </form>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>