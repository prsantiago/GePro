const formularioProfesor = document.querySelector('#profesor'),
        formularioAlumno = document.querySelector('#alumno'),
        formularioProgreso = document.querySelector('#progreso'),
        formularioEditarSeguimiento = document.querySelector('#editar-seguimiento'),
        formularioProyecto = document.querySelector('#proyecto'),
        formularioComentario = document.querySelector('#comentario'),
        loginProfesor = document.querySelector('#login-profesor'),
        loginAlumno = document.querySelector('#login-alumno'),
        formularioProceso = document.querySelector('#proceso'),
        borrarProyecto = document.querySelector("#listado-proyectos tbody");

eventListeners();

function eventListeners() {
    if(formularioProfesor)
        formularioProfesor.addEventListener('submit', leerFormularioProfesor);
    if(formularioAlumno)
        formularioAlumno.addEventListener('submit', leerFormularioAlumno);
    if(formularioProgreso)
        formularioProgreso.addEventListener('submit', leerFormularioProgreso);
    if(formularioEditarSeguimiento)
        formularioEditarSeguimiento.addEventListener('submit', leerFormularioEditarSeguimiento);
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
    if(borrarProyecto)
        borrarProyecto.addEventListener('click', eliminarProyecto);
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
        
        insertarProfesorBD(infoContacto, accion_profesor);
    }
}

/** Inserta en la base de datos via Ajax */
function insertarProfesorBD(datos, accion) {
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
                if(accion === 'crear') {
                    alert("Usuario creado");
                    window.location.href = 'index.php';
                } else if(accion === 'editar') {
                    alert("Usuario editado");
                    window.location.href = 'inicio.php';
                }
            } else {
                alert(respuesta.error);
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
        insertarAlumnoBD(infoContacto, accion_alumno); 
    }
}

/** Inserta en la base de datos via Ajax */
function insertarAlumnoBD(datos, accion) {
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
                if(accion === 'crear') {
                    alert("Usuario creado");
                    window.location.href = 'nuevo-proyecto.php';
                } else if(accion === 'editar') {
                    alert("Usuario editado");
                    window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
                }
            } else {
                alert(respuesta.error);
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
/* --------------------------------------- Proyecto ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProyecto(e) {
    e.preventDefault();

    const accion = document.querySelector('#accion').value;

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
                if (accion === "crear") {
                    alert("Proyecto creado: "+respuesta.nombre);
                } else if (accion === "edi") {
                    alert("Proyecto editado: "+respuesta.nombre);                
                }
                window.location.href = 'inicio.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        } else {
            // const respuesta = JSON.parse(xhr.responseText);
            // console.log(respuesta);
            console.log(xhr.responseText);
        }
    }
        // Enviar la petición
    xhr.send(datos);
}

function eliminarProyecto(e) {
    if (e.target.parentElement.classList.contains('btn-borrar')) {
        // Tomar el ID
        const id = e.target.parentElement.getAttribute('data-id');
        // const id = 22;

        // Confirmar decision
        const confirmacion = confirm("Confirma la decisión");
        const elementoDOM = e.target.parentElement.parentElement.parentElement;

        if (confirmacion) {
            const xhr = new XMLHttpRequest();

            xhr.open('GET', `inc/modelos/modelo-proyecto.php?id=${id}&accion=borrar`, true);
            
            xhr.onload = function() {
                if (this.status === 200) {
                    const respuesta = JSON.parse(xhr.responseText);

                    if (respuesta.respuesta === 'correcto') {
                        // Eliminar el registro del DOM
                        elementoDOM.remove();
                        alert('Proyecto eliminado');
                        // window.location.href = 'inicio.php';
                    } else {
                        alert('Error al eliminar proyecto');
                        console.log(respuesta);
                    }
                }
            }

            xhr.send();
        }

        console.log(id, confirmacion, elementoDOM);
    }
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
                window.location.href = 'comentarios.php?etapa='+respuesta.id_etapa+'&actividad='+respuesta.id_actividad;
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        } else {
            console.log(xhr.responseText);
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
            comFinal = document.querySelector('#comFinal').value,
            accion = activeElement.value;

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData();
    datos.append('fecha_proceso', fecha_proceso);
    datos.append('comFinal', comFinal);
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
            
            // console.log(xhr.responseText);

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

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Seguimiento ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioEditarSeguimiento(e) {
    e.preventDefault();

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData(formularioEditarSeguimiento);
    console.log(...datos);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-progreso.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);
            // console.log(xhr.responseText);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'historial.php?id='+respuesta.id_seguimiento;
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        } else {
            // const respuesta = JSON.parse(xhr.responseText);
            console.log(xhr.responseText);
            // console.log(respuesta);
        }
    }
        // Enviar la petición
    xhr.send(datos);
}