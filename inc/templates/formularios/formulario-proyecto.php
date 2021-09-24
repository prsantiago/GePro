<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre Proyecto</label>
        <input 
            name= "nombre"
            type="text" 
            placeholder="Nombre Proyecto" 
            id="nombre"
            value= "<?php echo !empty($nombre)  ? $nombre : ""?>"
            required    
        >
    </div>
    <div class="campo">
        <label for="id_alumno">Alumno</label><br>
        <select name="id_alumno" id="id_alumno" required>
            <?php 
            $alumnos = obtenerAlumnosRegistrados("'".$_SESSION['universidad_usuario']."'");
            if($alumnos->num_rows) {
            ?>
                <option value="">Seleccione un alumno registrado</option>
                <?php
                foreach($alumnos as $alumno) { 
                ?>
                <option value="<?php echo $alumno['id']?>" <?php echo (!empty($id_alumno) && $id_alumno==$alumno['id']) ? "selected" : ""?>>
                    <?php echo $alumno['nombre']." ".$alumno['apellido']." --- ".$alumno['matricula']?>
                </option>
            <?php   
                } 
            } else {
            ?>
                <option value="">
                    Sin alumnos registrados
                </option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="campo">
        <label for="id_coasesor">Coasesor (opcional)</label><br>
        <select name="id_coasesor" id="id_coasesor">
            <?php
            $profesores = obtenerProfesoresRegistrados("'".$_SESSION['universidad_usuario']."'");
            if($profesores->num_rows) {
            ?>
                <option value="">Seleccione un profesor registrado</option>
                <?php    
                foreach($profesores as $profesor) { 
                    if($profesor['id'] != $_SESSION['id_usuario']) {
                ?>
                        <option value="<?php echo $profesor['id']?>" <?php echo (!empty($id_coasesor) && $id_coasesor==$profesor['id']) ? "selected" : ""?>>
                            <?php echo $profesor['nombre']." ".$profesor['apellido']." --- ".$profesor['matricula']?>
                        </option>
            <?php  
                    } 
                } 
            } else {
            ?>
                <option value="">
                    Sin profesores registrados
                </option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="campo">
        <label for="fecha">Fecha de inicio</label>
        <input 
            name="fecha"
            type="date"
            placeholder="Fecha de inicio" 
            id="fecha"
            value="<?php echo !empty($fecha) ? $fecha : ""?>"
            required
        >
    </div>
    <div class="campo">
        <label for="descripcion">Descripción</label><br>
        <textarea id="descripcion" rows="4" cols="40" name="descripcion"><?php echo !empty($descripcion) ? $descripcion : ""?></textarea>
    </div>
</div>
        
<div class="campo enviar">
    <input name="accion" type="hidden" id="accion" value="<?php echo !empty($id_proyecto) ? "editar" : "crear"?>">
    <input name="id_proyecto" type="hidden" id="id_proyecto" value="<?php echo !empty($id_proyecto) ? $id_proyecto : ""?>">
    <input type="submit" class="boton" value="<?php echo !empty($id_proyecto) ? "Editar" : "Crear"?> proyecto">
</div>