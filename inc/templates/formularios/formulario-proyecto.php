<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre Proyecto</label>
        <input 
            type="text" 
            placeholder="Nombre Proyecto" 
            id="nombre"
            value=""
            required    
        >
    </div>
    <div class="campo">
        <label for="correo_alumno">Alumno</label><br>
        <select name="correo_alumno" id="correo_alumno">
            <?php 
            // para esta función, tuve que crear un nuevo campo en alumno llamado institución que es un int.
            $alumnos = obtenerAlumnosRegistrados(1);
            // las dos formas que traté de obtener los alumnos, pero ninguna de las dos jaló.
            // $alumnos = obtenerAlumnosRegistrados("UAM");
            // $alumnos = obtenerAlumnosRegistrados($_SESSION['universidad_usuario']);
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
        <label for="correo_coasesor">Coasesor (opcional)</label><br>
        <?php $profesores = obtenerProfesoresRegistrados("UAM"); ?>
        <select name="correo_coasesor" id="correo_coasesor">
            <?php
            // para esta función, tuve que crear un nuevo campo en profesor llamado institución que es un int.
            $profesores = obtenerProfesoresRegistrados(1);

            // las dos formas que traté de obtener los profesores, pero ninguna de las dos jaló.
            // $profesores = obtenerProfesoresRegistrados("UAM");
            // $profesores = obtenerProfesoresRegistrados($_SESSION['universidad_usuario']);
            if($profesores->num_rows) {
            ?>
                <option value="">Seleccione un profesor registrado</option>
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
    <input type="hidden" id="accion" value="crear">
    <input type="submit" class="boton" value="Crear proyecto">
</div>