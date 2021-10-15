<?php 
session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header('Location: index.php?login=false');
}

$user = $_SESSION['id_usuario'];

?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra-inicio">
        <?php include 'inc/templates/logos.php'; ?>

        <a class="vinculo" href="nuevo-proyecto.php">Nuevo proyecto</a>
        <a class="vinculo" href="editar-usuario.php">Editar Usuario</a>
        <a class="vinculo" href="index.php?login=false">Cerrar Sesión</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="contenedor bg-terciario contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <a href="historial_proy.php" class="btn">Historial de proyectos</a>
        <p class="total-proyectos">
            <span>
                <!-- Despliega el número de proyectos vigentes que tiene el profesor -->
                <?php 
                $proy = obtenerProyectosVigentes($user); 
                print_r($proy[0]); 
                ?>
            </span> 
            Proyectos vigentes
        </p>

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
                    // Regresa un arreglo con los datos de los proyectos vigentes que está asesorando
                    // Además de checar si de verdad se regresó algo
                    $proyectos = obtenerProyectos($user);
                    if(!empty($proyectos) && $proyectos->num_rows > 0) {
                        // Para cada proyecto se despliega: clave, nombre, alumno,
                        // botones de acción (mostrar el progreso, editar, borrar)
                        foreach($proyectos as $proyecto) { 
                    ?>
                            <tr>
                                <td><?php echo $proyecto['clave']?></td>
                                <td><?php echo $proyecto['proyecto']?></td>
                                <td><?php echo $proyecto['nombre']." ".$proyecto['apellido']?></td>
                                <td>
                                    <!-- mostrar progreso -->
                                    <!-- Se manda por GET el id del proyecto -->
                                    <a class="btn-check btn" href="progreso.php?id=<?php echo $proyecto['id']?>">
                                        <i class="fas fa-user-check"></i>
                                    </a>
                                    <!-- editar proyecto -->
                                    <!-- Se manda por GET el id del proyecto -->
                                    <?php if ($proyecto['id_asesor2'] != $user) {?>
                                    <a class="btn-editar btn" href="editar-proyecto.php?id=<?php echo $proyecto['id']?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- borrar proyecto -->
                                    <!-- Data-id del boton tiene el valor del id del proyecto -->
                                    <button data-id="<?php echo $proyecto['id']?>" type="button" class="btn-borrar btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php } ?>
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