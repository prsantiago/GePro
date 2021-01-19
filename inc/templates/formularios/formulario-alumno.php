<div class="campos">
    <div class="campo">
        <label for="nombre_alumno">Nombre(s): </label>
        <input 
            type="text" 
            id="nombre_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="apellido_alumno">Apellidos: </label>
        <input 
            type="text" 
            id="apellido_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="matricula_alumno">Matricula: </label>
        <input 
            type="text" 
            id="matricula_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="correo_alumno">Correo institucional: </label>
        <input 
            type="email" 
            id="correo_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="password_alumno">Password: </label>
        <input 
            type="password" 
            id="password_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="valpass_alumno">Validar password: </label>
        <input 
            type="password" 
            id="valpass_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="universidad_alumno">Institución a la que perteneces: </label>
        <select name="universidad_alumno" id="universidad_alumno">
            <option value="UAM">Universidad Autonoma Metropolitana</option>
            <option value="UACM">UACM</option>
            <option value="UNAM">UNAM</option>
            <option value="Tec">Tec</option>
        </select>
    </div>
    <div class="campo">
        <label for="division_alumno">División/Facultad a la que pertenece: </label>
        <input 
            type="text" 
            id="division_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="carrera_alumno">Carrera: </label>
        <input 
            type="text" 
            id="carrera_alumno" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="estado_alumno">Estado del alumno </label>
        <select name="estado_alumno" id="estado_alumno">
            <option value="1">Pre-tesista</option>
            <option value="2">Tesista</option>
        </select>
    </div>
</div>
<div class="campo enviar">
    <input type="hidden" id="accion_alumno" value="crear">
    <input type="submit" class="boton" value="Crear cuenta de alumno">
</div>