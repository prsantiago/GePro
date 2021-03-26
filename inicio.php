<?php session_start(); include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra-inicio">
        <?php include 'inc/templates/logos.php'; ?>

        <a href="nuevo-proyecto.php">Nuevo proyecto</a>
        <a href="editar-usuario.php">Editar Usuario</a>
        <a href="index.php?login=false">Cerrar Sesión</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="contenedor bg-terciario contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <p class="total-proyectos"><span>2</span> Proyectos</p>

        <div class="contenedor-tabla">
            <table id="listado-proyectos" class="listado-proyectos">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Estudiante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $proyectos = obtenerProyectos($_SESSION['id_usuario']);
                    if($proyectos->num_rows) {
                        foreach($proyectos as $proyecto) { 
                    ?>
                            <tr>
                                <td><?php echo $proyecto['clave']?></td>
                                <td><?php echo $proyecto['proyecto']?></td>
                                <td><?php echo $proyecto['nombre']." ".$proyecto['apellido']?></td>
                                <td>
                                    <a class="btn-check btn" href="progreso.php?id=<?php echo $proyecto['id']?>">
                                        <i class="fas fa-user-check"></i>
                                    </a>
                                    <a class="btn-editar btn" href="editar-proyecto.php?id=<?php echo $proyecto['id']?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button data-id="<?php echo $proyecto['id']?>" type="button" class="btn-borrar btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                    <?php   
                        } 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>