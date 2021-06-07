<?php session_start(); include 'inc/templates/header.php'; ?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <div class="logos">
            <img src="images\logos.png" alt="UAM">
        </div>
        <a href="index.php?login=false" class="btn volver">Volver</a>
    </div>
</div>


<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <h2>Instructivo de uso como profesor</h2>
        <ul>
            <li><a href="documents\Borrar_proyecto.pdf">Para borrar proyecto</a></li>
            <li><a href="documents\Crear_cuenta_de_alumno.pdf">Para crear una cuenta de alumno</a></li>
            <li><a href="documents\Crear_cuenta_de_profesor.pdf">Para crear una cuenta de profesor</a></li>
            <li><a href="documents\Crear_proyecto.pdf">Para crear un proyecto</a></li>
            <li><a href="documents\Editar_cuenta_profesor.pdf">Para editar una cuenta de profesor</a></li>
            <li><a href="documents\Editar_proyecto.pdf">Para editar un proyecto</a></li>
            <li><a href="documents\Editar_seguimiento.pdf">Para editar un seguimiento</a></li>
            <li><a href="documents\Enviar_Revisar_comentario_como_profesor.pdf">Para enviar/revisar comentario</a></li>
            <li><a href="documents\Iniciar_sesión_como_profesor.pdf">Para iniciar sesión</a></li>
            <li><a href="documents\Recuperar_contraseña_como_profesor.pdf">Para recuperar contraseña</a></li>
            <li><a href="documents\Registrar_seguimiento.pdf">Para registrar seguimiento</a></li>
            <li><a href="documents\Revisar_historial_de_seguimiento_como_profesor.pdf">Para revisar historial de seguimiento</a></li>
            <li><a href="documents\Revisar_proyectos_terminados.pdf">Para revisar proyectos terminados</a></li>
        </ul>
        <h2>Instructivo de uso como alumno</h2>
        <ul>
            <li><a href="documents\Editar_cuenta_alumno.pdf">Para editar cuenta de alumno</a></li>
            <li><a href="documents\Enviar_Revisar_comentario_como_alumno.pdf">Para enviar/revisar comentario</a></li>
            <li><a href="documents\Iniciar_sesión_como_alumno.pdf">Para iniciar sesión</a></li>
            <li><a href="documents\Recuperar_contraseña_como_alumno.pdf">Para recuperar contraseña</a></li>
            <li><a href="documents\Revisar_historial_de_seguimiento_como_alumno.pdf">Para revisar historial de seguimiento</a></li>
            <li><a href="documents\Ver_progreso_del_proyecto_como_alumno.pdf">Para ver progreso del proyecto</a></li>
        </ul>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>