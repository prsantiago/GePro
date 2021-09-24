<div class="campos">
    <div class="campo">
        <label for="nombre_alumno">Nombre(s): </label>
        <input
            name="nombre_alumno" 
            type="text" 
            id="nombre_alumno" 
            placeholder= "Nombre alumno"
            value = "<?php echo !empty($nombre) ? $nombre : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="apellido_alumno">Apellidos: </label>
        <input
            name="apellido_alumno" 
            type="text" 
            id="apellido_alumno" 
            placeholder="Apellido alumno"
            value = "<?php echo !empty($apellido) ? $apellido : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="matricula_alumno">Matricula: </label>
        <input
            name="matricula_alumno" 
            type="text" 
            id="matricula_alumno" 
            placeholder="Matricula alumno"
            value = "<?php echo !empty($matricula) ? $matricula : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="correo_alumno">Correo institucional: </label>
        <input
            name="correo_alumno" 
            type="email" 
            id="correo_alumno" 
            placeholder="Correo alumno"
            value = "<?php echo !empty($correo) ? $correo : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="password_alumno">Password: </label>
        <input
            name="password_alumno" 
            type="password" 
            id="password_alumno" 
            placeholder="Password de alumno"
            required
        >
    </div>
    <div class="campo">
        <label for="valpass_alumno">Validar password: </label>
        <input
            type="password" 
            id="valpass_alumno" 
            placeholder="Validar password de alumno"
            required
        >
    </div>
    <div class="campo">
        <label for="universidad_alumno">Institución a la que perteneces: </label>
        <select name="universidad_alumno" id="universidad_alumno" required>
            <option value = <?php echo !empty($universidad) ? $universidad : "";?>><?php echo !empty($universidad) ? $universidad : "---";?></option>
            <option value="UAM-A">UAM-A</option>
            <option value="UAM-L">UAM-L</option>
            <option value="UACM">UACM</option>
            <option value="UNAM">UNAM</option>
            <option value="IPN">IPN</option>
        </select>
    </div>
    <div class="campo">
        <label for="division_alumno">División/Facultad a la que pertenece: </label>
        <input
            name="division_alumno" 
            type="text" 
            id="division_alumno" 
            placeholder="Division alumno"
            value = "<?php echo !empty($division) ? $division : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="carrera_alumno">Carrera: </label>
        <input
            name="carrera_alumno" 
            type="text" 
            id="carrera_alumno" 
            placeholder="Carrera alumno"
            value = "<?php echo !empty($carrera) ? $carrera : "";?>"
            required
        >
    </div>
    <?php if (isset($_SESSION['tipo_usuario']) && !(strcmp($_SESSION['tipo_usuario'], 'profesor'))) {?>
        <div class="campo">
            <label for="estado_alumno">Estado del alumno </label>
            <select name="estado_alumno" id="estado_alumno">
                <option value="1">Pre-tesista</option>
                <option value="2">Tesista</option>
            </select>
        </div>
    <?php } ?>
</div>
<div class="campo enviar">
    <input name="accion" type="hidden" id="accion" value= <?php echo (isset($_SESSION['tipo_usuario']) && !(strcmp($_SESSION['tipo_usuario'], 'profesor'))) ? "crear" : "editar";?>>
    <input type="submit" class="boton" value="<?php echo (isset($_SESSION['tipo_usuario']) && !(strcmp($_SESSION['tipo_usuario'], 'profesor'))) ? "Crear" : "Editar";?> cuenta de alumno">
</div>