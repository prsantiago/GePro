<!-- Despliega el historial de seguimientos que se tienen del proyecto en cuestión (alumno y profesor)-->
<!-- Además da la posibilidad de editar la fecha de entrega de algún seguimiento (solo profesor) -->
<?php session_start(); 
include 'inc/templates/header.php';
include 'inc/funciones/funciones.php';
$id_proyecto = $_SESSION['id_proyecto'];?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="progreso.php?id= <?php echo $id_proyecto; ?>" class="btn volver">Volver</a>
    </div>
</div>


<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <h4>Historial de seguimiento de proyecto</h4>

        <div class="contenedor-tabla">
            <table id="listado-seguimientos" class="listado-seguimientos">
                <thead>
                    <tr>
                        <th>Etapa</th>
                        <th>Actividad</th>
                        <th>Fecha de entrega</th>
                        <!-- Solo si el usuario es profesor tiene la posibilidad de editar -->
                        <?php 
                        if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] == 'profesor') {
                        ?>
                            <th>Editar<th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Regresa todos los seguimientos registrados de un proyecto en específico
                    // Además de checar que si se regreso algo
                    $seguimientos = obtenerSeguimientos($id_proyecto);
                    if($seguimientos->num_rows > 0) {
                        // Para cada seguimiento se muestra la etapa, actividad, fecha de entrega
                        // Además del boton para editar la fecha, solo si se es un profesor
                        foreach($seguimientos as $seguimiento) { 
                    ?>
                            <tr>
                                <td><?php echo $seguimiento['etapa']?></td>
                                <td><?php echo $seguimiento['actividad']?></td>
                                <td><?php echo $seguimiento['fecha_entrega']?></td>
                                <?php 
                                if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] == 'profesor' && !is_null($seguimiento['fecha_entrega'])) {
                                ?>
                                    <td>
                                        <!-- Editar fecha de entraga -->
                                        <!-- Manda por GET el id del seguimiento -->
                                        <a class="btn-editar btn" href="editar-seguimiento.php?id=<?php echo $seguimiento['id']?>">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>
                    <?php   
                        } 
                    } else {
                    ?>
                        <tr>
                            <td>Introducción</td>
                            <td>Entrega</td>
                            <td>dd/mm/aaaa</td>
                            <td>
                                <a class="btn-editar btn" href="#">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>