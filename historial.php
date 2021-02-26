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
        <p><?php print_r($_SESSION); ?></p>
        <p>Historial de seguimiento de proyecto</p>

        <div class="contenedor-tabla">
            <table id="listado-seguimientos" class="listado-seguimientos">
                <thead>
                    <tr>
                        <th>Etapa</th>
                        <th>Proceso</th>
                        <th>Fecha de entrega</th>
                        <?php 
                        if ($_SESSION["tipo_usuario"] == 'profesor') {
                        ?>
                            <th>Editar<th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $seguimientos = obtenerSeguimientos($_SESSION['id_proyecto']);
                    if($seguimientos->num_rows) {
                        foreach($seguimientos as $seguimiento) { 
                    ?>
                            <tr>
                                <td><?php echo $seguimiento['etapa']?></td>
                                <td><?php echo $seguimiento['proceso']?></td>
                                <td><?php echo $seguimiento['entrega']?></td>
                                <?php 
                                if ($_SESSION["tipo_usuario"] == 'profesor') {
                                ?>
                                    <td>
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