<!-- Pagina donde se muestra el avance de un proyecto. -->

<!-- FUNCIONES DE UN ALUMNO -->
<!-- Se llega al ingresar una clave de proyecto desde index.php -->
<!-- Hay un area para que SOLO el alumno pueda iniciar sesión, con esto puede realizar las siguientes acciones: -->
<!--    - Revisar los comentarios que se han posteado en etapas y/o actividades al ingresar a comentarios.php por <a>.
        - Hacer comentarios en las etapas y/o actividades. -->

<!-- FUNCIONES DE UN PROFESOR -->
<!-- Se llega al seleccionar un proyecto de la lista de proyectos que se desplegan en inicio.php -->
<!-- Realiza las siguientes acciones: -->
<!--    - Revisar los comentarios que se han posteado en etapas y/o actividades al ingresar a comentarios.php por <a>.
        - Hacer comentarios en las etapas y/o actividades.
        - Editar la fecha de entraga de una actividad ingresando a historial.php
        - Dar por entregada o aprobar una actividad
        - Dar por finalizado un proyecto e ingresar el comentario final -->

<!-- Además hay un link que te lleva a historial.php -->
<?php 
session_start();
/*if(!isset($_SESSION['id_usuario'])){
    header('Location: index.php?login=false');
} */
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

// FIXME: Mala práctica: Se estaban teniendo problemas al ponerlo en una función en funciones.php
// Por GET se recibe el id del proyecto, este id se obtiene indirectamente de la clave que se ingresa en el form de proyecto en index.php 
// Se regresa el id, id_etapa y id_actividad del seguimiento actual del proyecto (Por eso se selecciona el seguimiento con max(id) del proyecto)
$id_proyecto = $_GET['id'];
$stmt = $conn->prepare("SELECT id,proxima_entrega,id_etapa,id_actividad FROM seguimiento_vigente WHERE id =(SELECT MAX(id) FROM seguimiento_vigente WHERE id_proyecto = ?)");
$stmt->bind_param('i', $id_proyecto);
$stmt->execute();
$stmt->bind_result($id_seguimiento,$proximaEntrega,$id_etapa,$id_actividad);
$stmt->fetch();
// Como esta info se requerirá en funciones posteriores, se guardan en variables de sesión
$_SESSION['id_proyecto']=$id_proyecto;
$_SESSION['id_seguimiento']=$id_seguimiento;
$_SESSION['id_etapa']=$id_etapa;
$_SESSION['id_actividad']=$id_actividad;
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <!-- Si es profesor, solo podrá volver a inicio.php -->
        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'profesor') { ?>
            <a href="inicio.php" class="btn volver">Volver</a>
        <!-- Si es alumno y ya inició sesión, podrá editar su cuenta o cerrar sesión -->
        <?php } else if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'alumno') { ?>
            <a class="vinculo" href="editar-usuario.php">Editar Usuario</a>
            <a class="vinculo" href="index.php?login=false">Cerrar Sesión</a>
        <!-- Si es alumno y no ha iniciado sesión, form para ingresar a su cuenta -->
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
                        <input name="accion" type="hidden" id="accion" value="login">
                        <input type="submit" class="boton" value="Iniciar sesión">
                    </div>
                </form>
                <div class="opciones-login">
                    <div class="campo">
                        <a class="vinculo" href="recuperar-cuenta.php?user=al">Recuperar contraseña</a>
                    </div>
                </div> 
            </div>
            <!-- <a href="index.php?login=false" class="btn volver">Volver</a> -->
        <?php } ?>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <!-- <p><?php print_r($_SESSION); ?></p> -->
        <h1>Progreso del proyecto</h1>
        <a href="historial.php" class="btn">Historial del seguimiento</a>
        
        <h4 class="pad">Etapas</h4>
        <div class="etapas">
            <div id="etapa-1" class="etapa bg-cuaternario">
                <p class="blanco">Introducción</p>
                <?php 
                if($id_etapa>1){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a class="blanco" href="comentarios.php?etapa=1&actividad=3" class="btn fechas"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p class="blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3);
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else {
                    if(isset($_SESSION['login'])) { ?>
                        <a class="blanco" href="comentarios.php?etapa=1&actividad=3" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-2" class="etapa <?php if($id_etapa>=2) echo 'bg-cuaternario'?>">
                <p <?php if($id_etapa>=2) echo 'class="blanco"'; ?>>Marco teórico</p>
                <?php 
                if($id_etapa>2){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=2&actividad=3" class="btn fechas blanco"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p class="blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3);
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==2){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=2&actividad=3" class="btn fechas blanco">En proceso</a>
                    <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-3" class="etapa <?php if($id_etapa>=3) echo 'bg-cuaternario'?>">
                <p <?php if($id_etapa>=3) echo 'class="blanco"'; ?>>Desarrollo</p>
                <?php 
                if($id_etapa>3){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=3&actividad=3" class="btn fechas blanco"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p class="blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3);  
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==3){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=3&actividad=3" class="btn fechas blanco">En proceso</a>
                    <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-4" class="etapa <?php if($id_etapa>=4) echo 'bg-cuaternario'?>">
                <p <?php if($id_etapa>=4) echo 'class="blanco"'; ?>>Resultados</p>
                <?php 
                if($id_etapa>4){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=4&actividad=3" class="btn fechas blanco"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p class="blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==4){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=4&actividad=3" class="btn fechas blanco">En proceso</a>
                    <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-5" class="etapa <?php if($id_etapa==5) echo 'bg-cuaternario'?>">
                <p <?php if($id_etapa==5) echo 'class="blanco"'; ?>>Tesis integrada</p>
                <?php 
                if($id_etapa==5 && $id_actividad<=4){?>
                    <p class="blanco">En proceso</p> <?php 
                } ?>
            </div>
        </div>

        <h4>Actividades</h4>
        <div class="actividades">
            <div id="actividad-1" class="actividad bg-cuaternario">
                <p class="blanco">Entrega</p>
                <?php 
                if($id_actividad>1){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=1" class="btn fechas blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,1);
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p class="blanco"><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,1);
                        echo $fecha_entrega[0]; ?> </p>
                <?php 
                    }
                } else { 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=1" class="btn fechas blanco">En proceso</a>
                    <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php 
                    } 
                }?>
            </div>

            <div id="actividad-2" class="actividad <?php if($id_actividad>=2) echo 'bg-cuaternario'?>">
                <p <?php if($id_actividad>=2) echo 'class="blanco"'; ?>>Retroalimentación</p>
                <?php 
                if($id_etapa<5){
                    if($id_actividad>2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                            echo $fecha_entrega[0]; ?></a>
                <?php 
                        } else { ?>
                            <p class="blanco"><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                            echo $fecha_entrega[0]; ?> </p>
                <?php   }
                    } else if($id_actividad==2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas blanco">En proceso</a>
                        <?php 
                        } else { ?>
                            <p class="blanco"> En proceso </p>
                        <?php
                        }
                    } else {
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                        if($fecha_entrega[0]!=0) { ?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas negro"><?php
                            echo $fecha_entrega[0]; ?></a>  <?php 
                        }
                    } 
                } else {
                    if($id_actividad>2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas blanco"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,3);
                            echo $fecha_entrega[0]; ?></a>
                <?php   } else { ?>
                            <p class="blanco"><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,3);
                            echo $fecha_entrega[0]; ?> </p>
                <?php   }
                    } else if($id_actividad==2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas blanco">En proceso</a>
                        <?php 
                        } else { ?>
                            <p class="blanco"> En proceso </p>
                        <?php
                        }
                    } else {
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                        if($fecha_entrega[0]!=0) { ?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas negro"><?php
                            echo $fecha_entrega[0]; ?></a>  <?php 
                        }
                    }  
                }?>
            </div>
            <?php 
            if($id_etapa == 5){ ?>
                <div id="actividad-4" class="actividad <?php if($id_actividad==4) echo 'bg-cuaternario'?>">
                <p <?php if($id_actividad==4) echo 'class="blanco"'; ?>>Presentación</p>
                <?php 
                if($id_etapa==5 && $id_actividad==4){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=4" class="btn fechas blanco">En proceso</a>
                <?php 
                    } else { ?>
                        <p class="blanco">En proceso</p>
                <?php    }
                }?>
                </div>
             <?php } ?>
            
        </div>
        <?php if(isset($_SESSION['tipo_usuario']) && !strcmp($_SESSION['tipo_usuario'], 'profesor')) { ?>
            <div class="confirmar-proceso">
                <form id="proceso" action="#" method="post">
                    <div class="campo" <?php if($id_actividad!=4) echo 'style="display: none;"'?>>
                        <label for="comFinal">Comentario global del proyecto:</label><br>
                        <textarea id="comFinal" rows="4" cols="40" name="comFinal"></textarea>
                    </div>
                    <input type="date" name="fecha_proceso" id="fecha_proceso" required>
                    <!-- botones -->
                    <?php 
                    if($id_actividad!=4) { 
                    ?>
                        <input name="Actividad-entregada" type="button" onclick="actualizarStatus('Actividad entregada')" class="btn-entrega" value="Actividad entregada">
                    <?php 
                    }
                    ?>
                    <input name="Aprobar-actividad" type="button" onclick="actualizarStatus('Aprobar actividad')" class="btn-entrega" value="Aprobar actividad">
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>