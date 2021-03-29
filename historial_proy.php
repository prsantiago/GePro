<?php session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
$id_profesor = $_SESSION['id_usuario'];?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="inicio.php" class="btn volver">Volver</a>
    </div>
</div>


<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <h4>Historial de proyectos</h4>

        <div class="contenedor-tabla">
            <table id="listado-seguimientos" class="listado-seguimientos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estudiante</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Término</th>
                        <th>Descripción</th>
                        <th>Comentario global</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $proyectos = obtenerHistorialProyectos($_SESSION['id_usuario']);
                    if($proyectos->num_rows > 0) {
                        foreach($proyectos as $proyecto) { 
                    ?>
                            <tr>
                                <td><?php echo $proyecto['proyecto']?></td>
                                <td><?php echo $proyecto['nombre']." ".$proyecto['apellido']?></td>
                                <td><?php echo $proyecto['fechaInicio']?></td>
                                <td><?php echo $proyecto['fechaFin']?></td>
                                <td><?php echo $proyecto['descripcion']?></td>
                                <td><?php echo $proyecto['comentarioFinal']?></td>
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