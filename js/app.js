const formularioProfesor = document.querySelector('#profesor'),
        formularioAlumno = document.querySelector('#alumno'),
        formularioProgreso = document.querySelector('#progreso'),
        formularioProyecto = document.querySelector('#proyecto');
        formularioComentario = document.querySelector('#comentario');
        loginProfesor = document.querySelector('#login-profesor'),
        loginAlumno = document.querySelector('#login-alumno');
        formularioProceso = document.querySelector('#proceso');

eventListeners();

function eventListeners() {
    if(formularioProfesor)
        formularioProfesor.addEventListener('submit', leerFormularioProfesor);
    if(formularioAlumno)
        formularioAlumno.addEventListener('submit', leerFormularioAlumno);
    if(formularioProgreso)
        formularioProgreso.addEventListener('submit', leerFormularioProgreso);
    if(formularioProyecto)
        formularioProyecto.addEventListener('submit', leerFormularioProyecto);
    if(formularioComentario)
        formularioComentario.addEventListener('submit', leerformularioComentario);
    if(loginProfesor)
        loginProfesor.addEventListener('submit', validarProfesor);
    if(loginAlumno)
        loginAlumno.addEventListener('submit', validarAlumno);
    if(formularioProceso)
        formularioProceso.addEventListener('submit', actualizarStatus);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Profesor ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProfesor(e) {
    e.preventDefault();

    // Leer los datos de los inputs
    const password_profesor = document.querySelector('#password_profesor').value,
        valpass_profesor = document.querySelector('#valpass_profesor').value,
        accion_profesor = document.querySelector('#accion').value;

    if (valpass_profesor !== password_profesor) {
        alert('Contraseñas no coinciden');
    } else {
        // Pasa la validacion, crear llamado a Ajax
        const infoContacto = new FormData(formularioProfesor);

        if (accion_profesor === 'crear') {
            insertarProfesorBD(infoContacto);
            // console.log(...infoContacto);
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
    const password_alumno = document.querySelector('#password_alumno').value,
        valpass_alumno = document.querySelector('#valpass_alumno').value,
        accion_alumno = document.querySelector('#accion').value;

    if (valpass_alumno !== password_alumno) {
        alert('Contraseñas no coinciden');
    } else {
        // Pasa la validacion, crear llamado a Ajax
        const infoContacto = new FormData(formularioAlumno);

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
/* --------------------------------------- Log in ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function validarProfesor(e) {
    e.preventDefault();

    // datos que se envian al servidor
    const datos = new FormData(loginProfesor);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-profesor.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.usuario);                
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
          accion = document.querySelector('#accion').value;

    // datos que se envian al servidor
    const datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('password', password);
    datos.append('accion', accion);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-alumno.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.usuario);
                window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
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

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    // const datos = new FormData(formularioProgreso);
    // console.log(...datos);

    const clave = document.querySelector('#clave').value,
    accion = document.querySelector('#accion').value;

    // // mandar ejecutar Ajax
    // // datos que se envian al servidor
    const datos = new FormData();
    datos.append('clave', clave);
    datos.append('accion', accion);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
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
/* --------------------------------------- Proyecto ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProyecto(e) {
    e.preventDefault();

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData(formularioProyecto);
    // console.log(...datos);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'inicio.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        } else {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
        }
    }
        // Enviar la petición
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Comentario ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerformularioComentario(e) {
    e.preventDefault();

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData(formularioComentario);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-comentario.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert('Comentario agregado');
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        } else {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
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
    const datos = new FormData();
    datos.append('clave', clave);
    datos.append('accion', accion);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        }
    }
        // Enviar la petición
    xhr.send(datos);
}


function actualizarStatus(e) {
    e.preventDefault();

    var activeElement = document.activeElement;
    const fecha_proceso = document.querySelector('#fecha_proceso').value,
        accion = activeElement.value;

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData();
        datos.append('fecha_proceso', fecha_proceso);
        datos.append('accion', accion);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-progreso.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
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