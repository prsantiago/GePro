<?php session_start(); 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';

$id_proyecto = $_GET['id'];
$stmt = $conn->prepare("SELECT id, id_entrega, id_proceso FROM seguimiento_vigente WHERE id =(SELECT MAX(id) FROM seguimiento_vigente WHERE id_proyecto = ?)");
$stmt->bind_param('i', $id_proyecto);
$stmt->execute();
$stmt->bind_result($id_seguimiento, $id_entrega, $id_proceso);
$stmt->fetch();
$_SESSION['id_proyecto']=$id_proyecto;
$_SESSION['id_seguimiento']=$id_seguimiento;
$_SESSION['id_entrega']=$id_entrega;
$_SESSION['id_proceso']=$id_proceso;
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <?php if ($_SESSION['tipo_usuario'] == 'profesor') { ?>
            <a href="inicio.php" class="btn volver">Volver</a>
        <?php } else if ($_SESSION['tipo_usuario'] == 'alumno') { ?>
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
        <a href="historial.php" class="btn">Historial del seguimiento</a>

        <div class="entregas">
            <div id="entrega-1" class="entrega bg-cuaternario">
                <p>Introducción</p>
                <?php if($id_entrega>1){ 
                if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php?proyecto=<?php echo $_SESSION['id_proyecto']?>&etapa=1&tipo=etapa" class="btn fechas"><?php 
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3); 
                    echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,1,3);
                    echo $fecha_entrega[0]; ?></p>
                <?php } }
                else {?>
                    <p>En proceso</p>
                <?php } ?>
            </div>
            <div id="entrega-2" class="entrega <?php if($id_entrega>=2) echo 'bg-cuaternario'?>">
                <p>Marco teórico</p>
                <?php if($id_entrega>2){ 
                if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php?proyecto=<?php echo $_SESSION['id_proyecto']?>&etapa=2&tipo=etapa" class="btn fechas"><?php 
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3); 
                    echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,2,3);
                    echo $fecha_entrega[0]; ?></p>
                <?php } }
                else if($id_entrega==2){?>
                    <p>En proceso</p>
                <?php } ?>
            </div>
            <div id="entrega-3" class="entrega <?php if($id_entrega>=3) echo 'bg-cuaternario'?>">
                <p>Desarrollo</p>
                <?php if($id_entrega>3){ 
                if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php?proyecto=<?php echo $_SESSION['id_proyecto']?>&etapa=3&tipo=etapa" class="btn fechas"><?php 
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3); 
                    echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,3,3);  
                    echo $fecha_entrega[0]; ?></p>
                <?php } }
                else if($id_entrega==3){?>
                    <p>En proceso</p>
                <?php } ?>
            </div>
            <div id="entrega-4" class="entrega <?php if($id_entrega>=4) echo 'bg-cuaternario'?>">
                <p>Resultados</p>
                <?php if($id_entrega>4){ 
                if(isset($_SESSION['login'])) { ?>
                    <a href="comentarios.php?proyecto=<?php echo $_SESSION['id_proyecto']?>&etapa=4&tipo=etapa" class="btn fechas"><?php 
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                    echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php 
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,4,3); 
                    echo $fecha_entrega[0]; ?></p>
                <?php } }
                else if($id_entrega==4){?>
                    <p>En proceso</p>
                <?php } ?>
            </div>
            <div id="entrega-5" class="entrega <?php if($id_entrega==5) echo 'bg-cuaternario'?>">
                <p>Tesis integrada</p>
                <?php if($id_entrega==5 && $id_proceso==4){ 
                $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,5,4);
                if($fecha_entrega[0]!=0){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?proyecto=<?php echo $_SESSION['id_proyecto']?>&etapa=5&tipo=etapa" class="btn fechas"><?php  
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php
                        echo $fecha_entrega[0]; ?></p>
                <?php }  
                } else {?>
                    <p>En proceso</p>
                <?php } }else if($id_entrega==5 && $id_proceso<4){?>
                <p>En proceso</p> <?php } ?>
            </div>
        </div>

        <div class="procesos">
            <div id="proceso-1" class="proceso bg-cuaternario">
                <p>Entrega</p>
                <?php if($id_proceso>1){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,1);
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                        <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,1);
                            echo $fecha_entrega[0]; ?> </p>
                <?php }} else { ?>
                    <p>En proceso</p>
                <?php } ?>
            </div>
            <div id="proceso-2" class="proceso <?php if($id_proceso>=2) echo 'bg-cuaternario'?>">
                <p>Retroalimentación</p>
                <?php if($id_entrega<5){
                if($id_proceso>2){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,2);
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                        <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,2);
                            echo $fecha_entrega[0]; ?> </p>
                <?php }} else if($id_proceso==2){ ?>
                    <p>En proceso</p>
                <?php } else {
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,2);
                    if($fecha_entrega[0]!=0) { ?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php
                        echo $fecha_entrega[0]; ?></a>  <?php }
                    } }
                else {
                    if($id_proceso>2){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,3);
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                        <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,3);
                            echo $fecha_entrega[0]; ?> </p>
                <?php }} else if($id_proceso==2){ ?>
                    <p>En proceso</p>
                <?php } else {
                    $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,2);
                    if($fecha_entrega[0]!=0) { ?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php
                        echo $fecha_entrega[0]; ?></a>  <?php 
                    }}  }?>
            </div>
            <!-- div de la etapa de Aceptación, en caso de que los profesores lo quieran
            <div id="proceso-3" class="proceso <?php if($id_proceso>=3) echo 'bg-cuaternario'?>">
                <p>Aceptación</p>
                <?php if($id_proceso>3){ 
                    if(isset($_SESSION['login'])){?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,3);
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                        <p><?php  $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,$id_entrega,1);
                            echo $fecha_entrega[0]; ?> </p>
                <?php }} else if($id_proceso==3){ ?>
                    <p>En proceso</p>
                <?php } ?>
            </div>-->
            <div id="proceso-4" class="proceso <?php if($id_proceso==4) echo 'bg-cuaternario'?>">
                <p>Presentación</p>
                <?php if($id_entrega==5 && $id_proceso==4){ 
                $fecha_entrega = obtenerFechaSeguimiento($id_proyecto,5,4);
                if($fecha_entrega[0]!=0){ 
                    if(isset($_SESSION['login'])) { ?>
                        <a href="comentarios.php?tipo=actividad" class="btn fechas"><?php  
                        echo $fecha_entrega[0]; ?></a>
                <?php } else { ?>
                    <p><?php
                        echo $fecha_entrega[0]; ?></p>
                <?php }  
                } else {?>
                    <p>En proceso</p>
                <?php } }?>
            </div>
        </div>
        <?php if(!strcmp($_SESSION['tipo_usuario'], 'profesor')) { ?>
            <div class="confirmar-proceso">
                <form id="proceso" action="#" method="post">
                    <input type="date" name="fecha_proceso" id="fecha_proceso" required>
                    <!-- botones -->
                    <?php if($id_proceso!=4) 
                    echo '<input type="submit" class="boton" value="Actividad entregada">'?>
                    <input type="submit" class="boton" value="Aprobar actividad">
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php include 'inc/templates/footer.php'; ?>