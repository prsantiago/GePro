<?php 
session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

$id_proyecto = $_GET['id'];
$stmt = $conn->prepare("SELECT id,proxima_entrega,id_etapa,id_actividad FROM seguimiento_vigente WHERE id =(SELECT MAX(id) FROM seguimiento_vigente WHERE id_proyecto = ?)");
$stmt->bind_param('i', $id_proyecto);
$stmt->execute();
$stmt->bind_result($id_seguimiento,$proximaEntrega,$id_etapa,$id_actividad);
$stmt->fetch();
$_SESSION['id_proyecto']=$id_proyecto;
$_SESSION['id_seguimiento']=$id_seguimiento;
$_SESSION['id_etapa']=$id_etapa;
$_SESSION['id_actividad']=$id_actividad;
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <?php if ($_SESSION['tipo_usuario'] == 'profesor') { ?>
            <a href="inicio.php" class="btn volver">Volver</a>
        <?php } else if ($_SESSION['tipo_usuario'] == 'alumno') { ?>
            <a href="editar-usuario.php">Editar Usuario</a>
            <a href="index.php?login=false">Cerrar Sesión</a>
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
                        <a href="recuperar-cuenta.php">Recuperar contraseña</a>
                    </div>
                </div> 
            </div>
            <!-- <a href="index.php?login=false" class="btn volver">Volver</a> -->
        <?php } ?>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <p><?php print_r($_SESSION); ?></p>
        <h1>Progreso del proyecto</h1>
        <!-- FIXME: cambiar a color negro los <a> cuando no estén rellenos -->
        <!-- FIXME: Todos los <a>, una vez que ha sido logueado -->
        <!-- FIXME: Log in de alumno, solo si es el progreso de su proyecto? -->
        <a href="historial.php" class="btn">Historial del seguimiento</a>
        <div class="etapas">
            <div id="etapa-1" class="etapa bg-cuaternario">
                <p>Introducción</p>
                <?php 
                if($id_etapa>1){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=1&actividad=3" class="btn fechas"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3);
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else {
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=1&actividad=3" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p>En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-2" class="etapa <?php if($id_etapa>=2) echo 'bg-cuaternario'?>">
                <p>Marco teórico</p>
                <?php 
                if($id_etapa>2){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=2&actividad=3" class="btn fechas"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3);
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==2){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=2&actividad=3" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p>En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-3" class="etapa <?php if($id_etapa>=3) echo 'bg-cuaternario'?>">
                <p>Desarrollo</p>
                <?php 
                if($id_etapa>3){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=3&actividad=3" class="btn fechas"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3);  
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==3){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=3&actividad=3" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p>En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-4" class="etapa <?php if($id_etapa>=4) echo 'bg-cuaternario'?>">
                <p>Resultados</p>
                <?php 
                if($id_etapa>4){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=4&actividad=3" class="btn fechas"><?php 
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                        echo $fecha_entrega[0]; ?></p>
                <?php 
                    } 
                } else if($id_etapa==4){
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=3&actividad=3" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p>En proceso</p>
                <?php 
                    } 
                }?>
            </div>
            <div id="etapa-5" class="etapa <?php if($id_etapa==5) echo 'bg-cuaternario'?>">
                <p>Tesis integrada</p>
                <?php 
                if($id_etapa==5 && $id_actividad<=4){?>
                    <p>En proceso</p> <?php 
                } ?>
            </div>
        </div>

        <div class="actividades">
            <div id="actividad-1" class="actividad bg-cuaternario">
                <p>Entrega</p>
                <?php 
                if($id_actividad>1){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=1" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,1);
                        echo $fecha_entrega[0]; ?></a>
                <?php 
                    } else { ?>
                        <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,1);
                        echo $fecha_entrega[0]; ?> </p>
                <?php 
                    }
                } else { 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=1" class="btn fechas">En proceso</a>
                    <?php 
                    } else { ?>
                        <p>En proceso</p>
                <?php 
                    } 
                }?>
            </div>

            <div id="actividad-2" class="actividad <?php if($id_actividad>=2) echo 'bg-cuaternario'?>">
                <p>Retroalimentación</p>
                <?php 
                if($id_etapa<5){
                    if($id_actividad>2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                            echo $fecha_entrega[0]; ?></a>
                <?php 
                        } else { ?>
                            <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                            echo $fecha_entrega[0]; ?> </p>
                <?php   }
                    } else if($id_actividad==2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas">En proceso</a>
                        <?php 
                        } else { ?>
                            <p> En proceso </p>
                        <?php
                        }
                    } else {
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                        if($fecha_entrega[0]!=0) { ?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas"><?php
                            echo $fecha_entrega[0]; ?></a>  <?php 
                        }
                    } 
                } else {
                    if($id_actividad>2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,3);
                            echo $fecha_entrega[0]; ?></a>
                <?php   } else { ?>
                            <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,3);
                            echo $fecha_entrega[0]; ?> </p>
                <?php   }
                    } else if($id_actividad==2){ 
                        if(isset($_SESSION['login'])){?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas">En proceso</a>
                        <?php 
                        } else { ?>
                            <p> En proceso </p>
                        <?php
                        }
                    } else {
                        $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_etapa,2);
                        if($fecha_entrega[0]!=0) { ?>
                            <a href="comentarios.php?etapa=<?php echo $id_etapa ?>&actividad=2" class="btn fechas"><?php
                            echo $fecha_entrega[0]; ?></a>  <?php 
                        }
                    }  
                }?>
            </div>

            <div id="actividad-4" class="actividad <?php if($id_actividad==4) echo 'bg-cuaternario'?>">
                <p>Presentación</p>
                <?php 
                if($id_etapa==5 && $id_actividad==4){ ?>
                    <p>En proceso</p>
                <?php 
                } ?>
            </div>
        </div>
        <?php if(!strcmp($_SESSION['tipo_usuario'], 'profesor')) { ?>
            <div class="confirmar-proceso">
                <form id="proceso" action="#" method="post">
                    <div class="campo" <?php if($id_actividad!=4) echo 'style="display: none;"'?>>
                        <label for="comFinal">Comentario global del proyecto:</label><br>
                        <textarea id="comFinal" rows="4" cols="40" name="comFinal"></textarea>
                    </div>
                    <input type="date" name="fecha_proceso" id="fecha_proceso" required>
                    <!-- botones -->
                    <?php if($id_actividad!=4) 
                    echo '<input type="submit" class="boton" value="Actividad entregada">';?>
                    <input type="submit" class="boton" value="Aprobar actividad">
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>