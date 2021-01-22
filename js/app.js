const formularioProfesor = document.querySelector('#profesor'),
        formularioAlumno = document.querySelector('#alumno'),
        formularioProgreso = document.querySelector('#progreso'),
        loginProfesor = document.querySelector('#login-profesor'),
        loginAlumno = document.querySelector('#login-alumno');

eventListeners();

function eventListeners() {
    // Cuando el formulario profesor se ejecuta
    if(formularioProfesor)
        formularioProfesor.addEventListener('submit', leerFormularioProfesor);
    if(formularioAlumno)
        formularioAlumno.addEventListener('submit', leerFormularioAlumno);
    if(formularioProgreso)
        formularioProgreso.addEventListener('submit', leerFormularioProgreso);
    if(loginProfesor)
        loginProfesor.addEventListener('submit', validarProfesor);
    if(loginAlumno)
        loginAlumno.addEventListener('submit', validarAlumno);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Profesor ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProfesor(e) {
    e.preventDefault();

    // Leer los datos de los inputs
    const nombre_profesor = document.querySelector('#nombre_profesor').value,
        apellido_profesor = document.querySelector('#apellido_profesor').value,
        matricula_profesor = document.querySelector('#matricula_profesor').value,
        correo_profesor = document.querySelector('#correo_profesor').value,
        password_profesor = document.querySelector('#password_profesor').value,
        valpass_profesor = document.querySelector('#valpass_profesor').value,
        universidad_profesor = document.querySelector('#universidad_profesor').value,
        division_profesor = document.querySelector('#division_profesor').value,
        departamento_profesor = document.querySelector('#departamento_profesor').value,
        accion_profesor = document.querySelector('#accion_profesor').value;

    if (valpass_profesor !== password_profesor) {
        console.log(password_profesor, valpass_profesor);
        console.log('Contraseñas no coinciden');
    } else {
        // Pasa la validacion, crear llamado a Ajax
        const infoContacto = new FormData();
        infoContacto.append('nombre_profesor', nombre_profesor);
        infoContacto.append('apellido_profesor', apellido_profesor);
        infoContacto.append('matricula_profesor', matricula_profesor);
        infoContacto.append('correo_profesor', correo_profesor);
        infoContacto.append('password_profesor', password_profesor);
        infoContacto.append('universidad_profesor', universidad_profesor);
        infoContacto.append('division_profesor', division_profesor);
        infoContacto.append('departamento_profesor', departamento_profesor);
        infoContacto.append('accion', accion_profesor);

        if (accion_profesor === 'crear') {
            // crearemos un nuevo contacto
            insertarProfesorBD(infoContacto);
        } else {
            console.log('TODO editar');
        }
    }
}

/** Inserta en la base de datos via Ajax */
function insertarProfesorBD(datos) {
    // llamado a ajax
    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-profesor.php', true);

    // pasar los datos
    xhr.onload = function() {
        if (this.status === 200) {
            // Leemos la respuesta de PHP
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if(respuesta.respuesta === 'correcto') {
                //Resetear el formulario
                document.querySelector('form').reset();
                window.location.href = 'index.php';
            } else {
                alert(respues.error);
            }
        }
    }

    // enviar los datos
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Alumno ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioAlumno(e) {
    e.preventDefault();

    // Leer los datos de los inputs
    const nombre_alumno = document.querySelector('#nombre_alumno').value,
        apellido_alumno = document.querySelector('#apellido_alumno').value,
        matricula_alumno = document.querySelector('#matricula_alumno').value,
        correo_alumno = document.querySelector('#correo_alumno').value,
        password_alumno = document.querySelector('#password_alumno').value,
        valpass_alumno = document.querySelector('#valpass_alumno').value,
        universidad_alumno = document.querySelector('#universidad_alumno').value,
        division_alumno = document.querySelector('#division_alumno').value,
        carrera_alumno = document.querySelector('#carrera_alumno').value,
        estado_alumno = document.querySelector('#estado_alumno').value,
        accion_alumno = document.querySelector('#accion_alumno').value;

    if (valpass_alumno !== password_alumno) {
        alert('Contraseñas no coinciden');
    } else {
        // Pasa la validacion, crear llamado a Ajax
        const infoContacto = new FormData();
        infoContacto.append('nombre_alumno', nombre_alumno);
        infoContacto.append('apellido_alumno', apellido_alumno);
        infoContacto.append('matricula_alumno', matricula_alumno);
        infoContacto.append('correo_alumno', correo_alumno);
        infoContacto.append('password_alumno', password_alumno);
        infoContacto.append('universidad_alumno', universidad_alumno);
        infoContacto.append('division_alumno', division_alumno);
        infoContacto.append('carrera_alumno', carrera_alumno);
        infoContacto.append('estado_alumno', estado_alumno);
        infoContacto.append('accion_alumno', accion_alumno);

        if (accion_alumno === 'crear') {
            // crearemos un nuevo contacto
            insertarAlumnoBD(infoContacto);
        } else {
            console.log('TODO editar');
        }
    }
}

/** Inserta en la base de datos via Ajax */
function insertarAlumnoBD(datos) {
    // llamado a ajax
    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-alumno.php', true);

    // pasar los datos
    xhr.onload = function() {
        if (this.status === 200) {
            // Leemos la respuesta de PHP
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if(respuesta.respuesta === 'correcto') {
                //Resetear el formulario
                document.querySelector('form').reset();
                window.location.href = 'nuevo-proyecto.php';
            } else {
                alert(respues.error);
            }

        }
    }

    // enviar los datos
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Log in profesor ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function validarProfesor(e) {
    e.preventDefault();

    const usuario = document.querySelector('#usuario').value,
          password = document.querySelector('#password').value,
          tipo = document.querySelector('#tipo').value;

    
    // Ambos campos son correctos, mandar ejecutar Ajax

    // datos que se envian al servidor
    var datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('password', password);
    datos.append('accion', tipo);

    // crear el llamado a ajax
    var xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-profesor.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            var respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'inicio.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        }
    }
        // Enviar la petición
    xhr.send(datos);
}

function validarAlumno(e) {
    e.preventDefault();

    const usuario = document.querySelector('#usuario').value,
          password = document.querySelector('#password').value,
          tipo = document.querySelector('#tipo').value;

    
    // Ambos campos son correctos, mandar ejecutar Ajax

    // datos que se envian al servidor
    var datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('password', password);
    datos.append('accion', tipo);

    // crear el llamado a ajax
    var xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-alumno.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            var respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);
                window.location.href = 'progreso.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        }
    }
        // Enviar la petición
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Progreso ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProgreso(e) {
    e.preventDefault();

    const clave = document.querySelector('#clave').value,
        accion = document.querySelector('#accion').value;

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    var datos = new FormData();
    datos.append('clave', clave);
    datos.append('accion', accion);

    // crear el llamado a ajax
    var xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            var respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'progreso.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        }
    }
        // Enviar la petición
    xhr.send(datos);
}