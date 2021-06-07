<div class="campos">
    <div class="campo">
        <label for="nombre_profesor">Nombre(s): </label>
        <input 
            name="nombre_profesor" 
            type="text" 
            id="nombre_profesor" 
            placeholder="Nombre profesor"
            value = "<?php echo !empty($nombre) ? $nombre : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="apellido_profesor">Apellidos: </label>
        <input 
            name="apellido_profesor" 
            type="text" 
            id="apellido_profesor" 
            placeholder="Apellido profesor"
            value = "<?php echo !empty($apellido) ? $apellido : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="matricula_profesor">Número identificador/Matricula: </label>
        <input 
            name="matricula_profesor" 
            type="text" 
            id="matricula_profesor" 
            placeholder="Matricula profesor"
            value = "<?php echo !empty($matricula) ? $matricula : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="correo_profesor">Correo institucional: </label>
        <input 
            name="correo_profesor" 
            type="email" 
            id="correo_profesor" 
            placeholder="Correo profesor"
            value = "<?php echo !empty($correo) ? $correo : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="password_profesor">Password: </label>
        <input 
            name="password_profesor" 
            type="password" 
            id="password_profesor" 
            placeholder="Password profesor"
            required
        >
    </div>
    <div class="campo">
        <label for="valpass_profesor">Validar password: </label>
        <input  
            type="password" 
            id="valpass_profesor" 
            placeholder="Validar password Profesor"
            required
        >
    </div>
    <div class="campo">
        <label for="universidad_profesor">Institución a la que perteneces: </label>
        <select name="universidad_profesor" id="universidad_profesor" required>
            <option value = <?php echo !empty($universidad) ? $universidad : "";?>><?php echo !empty($universidad) ? $universidad : "---";?></option>>
            <option value="UAM-A">UAM-A</option>
            <option value="UAM-L">UAM-L</option>
            <option value="UACM">UACM</option>
            <option value="UNAM">UNAM</option>
            <option value="IPN">IPN</option>
        </select>
    </div>
    <div class="campo">
        <label for="division_profesor">División/Facultad a la que perteneces: </label>
        <input 
            name="division_profesor" 
            type="text" 
            id="division_profesor" 
            placeholder="Division profesor"
            value = "<?php echo !empty($division) ? $division : "";?>"
            required
        >
    </div>
    <div class="campo">
        <label for="departamento_profesor">Departamento al que perteneces: </label>
        <input 
            name="departamento_profesor" 
            type="text" 
            id="departamento_profesor" 
            placeholder="Departamento profesor"
            value = "<?php echo !empty($departamento) ? $departamento : "";?>"
            required
        >
    </div>
</div>
<div class="campo enviar">
<input name="accion" type="hidden" id="accion" value= <?php echo (!isset($_SESSION['tipo_usuario'])) ? "crear" : "editar";?>>
    <input type="submit" class="boton" value="<?php echo (!isset($_SESSION['tipo_usuario'])) ? "Crear" : "Editar";?> cuenta de profesor">
</div>