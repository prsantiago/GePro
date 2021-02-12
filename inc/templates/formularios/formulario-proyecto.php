<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre Proyecto</label>
        <input 
            name= "nombre"
            type="text" 
            placeholder="Nombre Proyecto" 
            id="nombre"
            value=""
            required    
        >
    </div>
    <div class="campo">
        <label for="id_alumno">Alumno</label><br>
        <select name="id_alumno" id="id_alumno">
            <?php 
            // $alumnos = obtenerAlumnosRegistrados("UAM");
            $alumnos = obtenerAlumnosRegistrados("'".$_SESSION['universidad_usuario']."'");
            if($alumnos->num_rows) {
            ?>
                <option value="">Seleccione un alumno registrado</option>
                <?php
                foreach($alumnos as $alumno) { 
                ?>
                <option value="<?php echo $alumno['id']?>">
                    <?php echo $alumno['nombre']." ".$alumno['apellido']."\t".$alumno['matricula']?>
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
                <option value="<?NULL?>">Seleccione un profesor registrado</option>
                <?php    
                foreach($profesores as $profesor) { 
                ?>
                <option value="<?php echo $profesor['id']?>">
                    <?php echo $profesor['nombre']." ".$profesor['apellido']."\t".$profesor['matricula']?>
                </option>
            <?php   
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
            value=""
            required
        >
    </div>
    <div class="campo">
        <label for="descripcion">Descripción</label><br>
        <textarea id="descripcion" rows="4" cols="40" name="descripcion">

        </textarea>
    </div>
</div>
        
<div class="campo enviar">
    <input name="accion" type="hidden" id="accion" value="crear">
    <input type="submit" class="boton" value="Crear proyecto">
</div>