<?php 
include 'inc/templates/header.php'; 
include 'inc/funciones/funciones.php';
include_once 'inc/funciones/conexion.php';
?>

<div class="bg-primario contenedor-barra">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>
        <a href="index.php?login=false" class="btn volver">Volver</a>
    </div>
</div>

<main class="bg-secundario contenedor-main">
    <div class="bg-terciario contenedor contenido sombra">
        <h4>Historial de proyectos</h4>
        <!-- Filtros de búsqueda -->
        <div class="filtros" >
            <div id="filters" class="asesor">
                <form id="form_filtros" method="post" autocomplete="off">
                    <p class="p-filter">Buscar por:                   
                    <select name="buscar_por">
                        <option value="proyecto">Nombre de Proyecto</option>
                    </select></p>
                    <p class="p-filter">Nombre a buscar:                   
                    <input type="text" name="nombre_buscar" class="filter" id="name_asesor">
                    (Nombre completo de proyecto. Nombre y apellido para asesor/alumno)</p>
                    <div >
                        <input type="hidden" id="tipo" value="filtrar">
                        <input type="submit" class="boton" value="Aplicar filtros">
                    </div>
                </form>
            </div>
        </div>
        <div class="contenedor-tabla">
            <table id="listado-total" class="listado-seguimientos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Asesor</th>
                        <th>Estudiante</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Término</th>
                        <th>Descripción</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Regresa un arreglo con los valores de los proyectos que están en el histórico
                    // Y checa que si se regresó algo
                    $proyectos = obtenerProyectosCompletados();
                    if($proyectos->num_rows > 0) {
                        // Por cada proyecto despliega los valores regresados
                        foreach($proyectos as $proyecto) { 
                    ?>
                            <tr>
                                <td><?php echo $proyecto['proyecto']?></td>
                                <td><?php echo $proyecto['nom_asesor']." ".$proyecto['ap_asesor'] ?></td>
                                <td><?php echo $proyecto['nombre']." ".$proyecto['apellido']?></td>
                                <td><?php echo $proyecto['fechaInicio']?></td>
                                <td><?php echo $proyecto['fechaFin']?></td>
                                <td><?php echo $proyecto['descripcion']?></td>
                                <td class="ended">Concluido</td>
                            </tr>
                    <?php   
                        } 
                    }
                    // Regresa un arreglo con los valores de los proyectos que están en el vigente
                    // Y checa que si se regresó algo
                    $proyectos = obtenerProyectosEnProceso();
                    if($proyectos->num_rows > 0) {
                        // Por cada proyecto despliega los valores regresados
                        foreach($proyectos as $proyecto) { 
                    ?>
                            <tr>
                                <td><?php echo $proyecto['proyecto']?></td>
                                <td><?php echo $proyecto['nom_asesor']." ".$proyecto['ap_asesor'] ?></td>
                                <td><?php echo $proyecto['nombre']." ".$proyecto['apellido']?></td>
                                <td><?php echo $proyecto['fechaInicio']?></td>
                                <td><?php echo $proyecto['fechaFin']?></td>
                                <td><?php echo $proyecto['descripcion']?></td>
                                <td class="progress">En proceso</td>
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

<script type="text/javascript">

    //var filtros = document.getElementById('filters');
    //filtros.style.display = "none";

    function ver_filtros(){
        if (filtros.style.display === "none") {
            filtros.style.display = "block";
        } else {
            filtros.style.display = "none";
        }
    }

    function buscarAsesor(){
        var tipo = 'asesor';
        var asesor = document.getElementById("name_asesor").value;
        if(asesor == ""){
            alert("Proporcione el nombre del asesor.")
        } else{
            var formData = new FormData();
            formData.append('tipo',tipo);
            formData.append('asesor',asesor);
            // crear el llamado a ajax
            $.ajax({
                url: 'inc/modelos/modelo-filtros.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(resp){
                    //registrarExcel(resp);
                    alert(resp);
                }
            });
        }
        return 0;
    }

</script>