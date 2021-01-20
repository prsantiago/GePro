<div class="campos">
    <div class="campo">
        <label for="nombre-proyecto">Nombre Proyecto</label>
        <input 
            type="text" 
            placeholder="Nombre Proyecto" 
            id="nombre-proyecto"
            value=""
            required    
        >
    </div>
    <div class="campo">
        <label for="correo-alumno">Correo del alumno</label>
        <input 
            type="text" 
            placeholder="Correo alumno" 
            id="correo-alumno"
            value=""
            required
        >
    </div>
    <div class="campo">
        <label for="correo-asesor">Correo del asesor</label>
        <input 
            type="text" 
            placeholder="Correo asesor" 
            id="correo-asesor"
            value=""
            required
        >
    </div>
    <div class="campo">
        <label for="correo-coasesor">Correo del coasesor</label>
        <input 
            type="text" 
            placeholder="Correo coasesor" 
            id="correo-coasesor"
            value=""
        >
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
    <input type="hidden" id="accion_proyecto" value="crear">
    <input type="submit" class="boton" value="Crear proyecto">
</div>