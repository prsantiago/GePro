<div class="campos">
    <div class="campo">
        <label for="nombre_profesor">Nombre(s): </label>
        <input 
            name="nombre_profesor" 
            type="text" 
            id="nombre_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="apellido_profesor">Apellidos: </label>
        <input 
            name="apellido_profesor" 
            type="text" 
            id="apellido_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="matricula_profesor">Número identificador/Matricula: </label>
        <input 
            name="matricula_profesor" 
            type="text" 
            id="matricula_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="correo_profesor">Correo institucional: </label>
        <input 
            name="correo_profesor" 
            type="email" 
            id="correo_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="password_profesor">Password: </label>
        <input 
            name="password_profesor" 
            type="password" 
            id="password_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="valpass_profesor">Validar password: </label>
        <input  
            type="password" 
            id="valpass_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="universidad_profesor">Institución a la que perteneces: </label>
        <select name="universidad_profesor" id="universidad_profesor">
            <option value="UAM">Universidad Autonoma Metropolitana</option>
            <option value="UACM">UACM</option>
            <option value="UNAM">UNAM</option>
            <option value="Tec">Tec</option>
        </select>
    </div>
    <div class="campo">
        <label for="division_profesor">División/Facultad a la que perteneces: </label>
        <input 
            name="division_profesor" 
            type="text" 
            id="division_profesor" 
            placeholder=""
            required
        >
    </div>
    <div class="campo">
        <label for="departamento_profesor">Departamento al que perteneces: </label>
        <input 
            name="departamento_profesor" 
            type="text" 
            id="departamento_profesor" 
            placeholder=""
            required
        >
    </div>
</div>
<div class="campo enviar">
    <input name="accion" type="hidden" id="accion" value="crear">
    <input type="submit" class="boton" value="Crear cuenta de profesor">
</div>