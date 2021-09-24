const formularioProfesor = document.querySelector('#profesor'),                       // crear-cuenta.php y editar-usuario.php
      formularioAlumno = document.querySelector('#alumno'),                           // nuevo-alumno.php y editar-usuario.php
      formularioProyecto = document.querySelector('#proyecto'),                       // nuevo-proyecto.php y editar-proyecto.php
      formularioProgreso = document.querySelector('#progreso'),                       // index.php
      loginProfesor = document.querySelector('#login-profesor'),                      // index.php
      formularioEditarSeguimiento = document.querySelector('#editar-seguimiento'),    // editar-seguimiento.php
      formularioComentario = document.querySelector('#comentario'),                   // comentarios.php
      loginAlumno = document.querySelector('#login-alumno'),                          // progreso.php
      formularioProceso = document.querySelector('#proceso'),                         // progreso.php
      formularioCuenta = document.querySelector('#recuperar-cuenta'),
      formularioPassword = document.querySelector('#nueva-pwd'),
      borrarProyecto = document.querySelector("#listado-proyectos tbody");            // inicio.php

eventListeners();

// Unicamente se añaden los EventListeners para los Selectors presentes en el archivo php que efectuó un submit/click
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
    if(formularioCuenta)
        formularioCuenta.addEventListener('submit', leerformularioRecuperaCuenta);
    if(formularioPassword)
        formularioPassword.addEventListener('submit', leerformularioNuevaPassword);
    if(borrarProyecto)
        borrarProyecto.addEventListener('click', eliminarProyecto);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Profesor ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

// Lee la contraseña, su validación y la acción a realizar del formulario de profesor (crear-cuenta.php y editar-usuario.php)
// checa que la contraseña coincida con su validación
//      - Si no coinciden, alerta de la diferencia
//      - Si coinciden, manda la acción que se llevará a cabo junto con el FormData a insertarProfesorBD
function leerFormularioProfesor(e) {
    e.preventDefault();
    const password_profesor = document.querySelector('#password_profesor').value,
        valpass_profesor = document.querySelector('#valpass_profesor').value,
        accion_profesor = document.querySelector('#accion').value;

    if (valpass_profesor !== password_profesor) {
        alert('Contraseñas no coinciden');
    } else {
        const infoContacto = new FormData(formularioProfesor);  // los datos se guardan en un FormData
        insertarProfesorBD(infoContacto, accion_profesor);
    }
}

/** Recibe el FormData y lo manda por POST a modelo-profesor.php
 *  Si la peticipon http regresa un 0K 200 se revisa la respuesta regresada:
 *      - Si es correcto, realiza un alert y un window.location.href dada la acción que se efectuó
 *      - Si es error, alerta el error */
function insertarProfesorBD(datos, accion) {
    // llamado a ajax  // abrir la conexion  // pasar los datos  // enviar los datos
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-profesor.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText); // Parseo de la respuesta del back-end
            console.log(respuesta);
            // console.log(xhr.responseText);

            if(respuesta.respuesta === 'correcto') {
                document.querySelector('form').reset();     // Resetear el formulario

                if(accion === 'crear') {                    // Acciones al crear usario
                    alert("Usuario creado. Correo: "+respuesta.correo);
                    window.location.href = 'index.php';
                } else if(accion === 'editar') {            // Acciones al editar usario
                    alert("Usuario editado");
                    window.location.href = 'inicio.php';
                }
            } else {
                alert(respuesta.error);
            }
        }
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Alumno ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

// Lee la contraseña, su validación y la acción a realizar del formulario de alumno (nuevo-alumno.php y editar-usuario.php)
// checa que la contraseña coincida con su validación
//      - Si no coinciden, alerta de la diferencia
//      - Si coinciden, manda la acción que se llevará a cabo junto con el FormData a insertarProfesorBD
function leerFormularioAlumno(e) {
    e.preventDefault();
    const password_alumno = document.querySelector('#password_alumno').value,
        valpass_alumno = document.querySelector('#valpass_alumno').value,
        accion_alumno = document.querySelector('#accion').value;

        console.log(accion_alumno);
    if (valpass_alumno !== password_alumno) {
        alert('Contraseñas no coinciden');
    } else {
        const infoContacto = new FormData(formularioAlumno);        // los datos se guardan en un FormData
        insertarAlumnoBD(infoContacto, accion_alumno); 
    }
}

/** Recibe el FormData y lo manda por POST a modelo-alumno.php
 *  Si la peticipon http regresa un 0K 200 se revisa la respuesta regresada:
 *      - Si es correcto, realiza un alert y un window.location.href dada la acción que se efectuó
 *      - Si es error, alerta el error */
function insertarAlumnoBD(datos, accion) {
    // llamado a ajax  // abrir la conexion  // pasar los datos  // enviar los datos
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-alumno.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);         // Parseo de la respuesta del back-end
            console.log(respuesta);

            if(respuesta.respuesta === 'correcto') {
                document.querySelector('form').reset();             // Resetear el formulario

                if(accion === 'crear') {                            // Acciones al crear alumno
                    alert("Usuario creado. Correo: "+respuesta.correo);
                    window.location.href = 'nuevo-proyecto.php';
                } else if(accion === 'editar') {                    // Acciones al editar alumno
                    alert("Usuario editado");
                    window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
                }
            } else {
                alert(respuesta.error);
            }
        } 
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Log in ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

// Los datos del formulario (index.php) para que el profesor inicie sesión se guardan en un FormData,
// el cual es enviado al back-end modelo-profesor.php por método POST
// Si la petición http fue exitosa (OK 200), se revisa la respuesta del back-end:
//      - Si es correcta se alerta y se cambia la página a inicio.php
//      - Si hubo un error, se alerta de él
function validarProfesor(e) {
    e.preventDefault();
    const datos = new FormData(loginProfesor);

    // llamado a ajax  // abrir la conexion  // pasar los datos  // enviar los datos
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-profesor.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);          // Parseo de la respuesta del back-end
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.usuario);   
                // alert(respuesta.nombre);              
                window.location.href = 'inicio.php';
            } else {
                alert(respuesta.error);
            }
        }
    }
    xhr.send(datos);
}

// Los datos del formulario (progreso.php) para que el alumno inicie sesión se guardan en un FormData,
// el cual es enviado al back-end modelo-alumno.php por método POST
// Si la petición http fue exitosa (OK 200), se revisa la respuesta del back-end:
//      - Si es correcta se alerta y se cambia la página a progreso.php del proyecto del alumno
//      - Si hubo un error, se alerta de él
function validarAlumno(e) {
    e.preventDefault();
    const datos = new FormData(loginAlumno);

    // llamado a ajax  // abrir la conexion  // pasar los datos  // enviar los datos
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-alumno.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);         // Parseo de la respuesta del back-end
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.usuario);
                // alert(respuesta.nombre); 
                window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
            } else {
                alert(respuesta.error);
            }
        }
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Proyecto ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

// Se lee la acción que se le realizará al proyecto. Los datos del formulario (nuevo-proyecto.php y editar-proyecto.php) 
// del proyecto se guardan en un FormData, el cual es enviado al back-end modelo-proyecto.php por método POST
// Si la petición http fue exitosa (OK 200), se revisa la respuesta del back-end:
//      - Si es correcta se alerta dependiendo la acción y se cambia la página a inicio.php
//      - Si hubo un error, se alerta de él
function leerFormularioProyecto(e) {
    e.preventDefault();
    const accion = document.querySelector('#accion').value;
    const datos = new FormData(formularioProyecto);

    // llamado a ajax  // abrir la conexion  // pasar los datos  // enviar los datos
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);             // Parseo de la respuesta del back-end
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                document.querySelector('form').reset();                 // Resetear el formulario
                if (accion === "crear") {                                 // Acción al crear un proyecto
                    alert("Proyecto creado: "+respuesta.nombre+". Correo: "+respuesta.correo);
                } else if (accion === "editar") {                          // Acción al editar un proyecto
                    alert("Proyecto editado: "+respuesta.nombre);
                } 
                window.location.href = 'inicio.php';
            } else {
                alert(respuesta.error);
            }
        } else {
            console.log(xhr.responseText);
        }
    }
    xhr.send(datos);
}

// TODO: Terminar comentarios a partir de aquí

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
                        window.location.href = 'inicio.php';
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
    const datos = new FormData(formularioComentario);
    console.log(...datos);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-comentario.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert('Comentario agregado. Correo: '+respuesta.correo);
                window.location.href = 'comentarios.php?etapa='+respuesta.id_etapa+'&actividad='+respuesta.id_actividad;
            } else {
                alert(respuesta.error);
            }
        } else {
            console.log(xhr.responseText);
        }
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Progreso ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioProgreso(e) {
    e.preventDefault();

    const clave = document.querySelector('#clave').value,
          accion = document.querySelector('#accion').value;
    const datos = new FormData();
    datos.append('clave', clave);
    datos.append('accion', accion);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);  
                window.location.href = 'progreso.php?id='+respuesta.id_proyecto;
            } else {
                alert(respuesta.error);
            }
        }
    }
    xhr.send(datos);
}


function actualizarStatus(accion_str) {
    // e.preventDefault();

    // var activeElement = document.activeElement;
    const fecha_proceso = document.querySelector('#fecha_proceso').value,
            comFinal = document.querySelector('#comFinal').value,
            accion = accion_str;

    const datos = new FormData(formularioProceso);
    datos.append('fecha_proceso', fecha_proceso);
    datos.append('comFinal', comFinal);
    datos.append('accion', accion);
    console.log(...datos);
    

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-progreso.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre+". Correo: "+respuesta.correo);                               
                window.location.href = 'inicio.php';
            } else {
                alert(respuesta.error);
            }
        }
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* --------------------------------------- Seguimiento ------------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerFormularioEditarSeguimiento(e) {
    e.preventDefault();

    const datos = new FormData(formularioEditarSeguimiento);
    console.log(...datos);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'inc/modelos/modelo-progreso.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre+". Correo: "+respuesta.correo);                
                window.location.href = 'historial.php?id='+respuesta.id_seguimiento;
            } else {
                alert(respuesta.error);
            }
        } else {
            console.log(xhr.responseText);
        }
    }
    xhr.send(datos);
}

/* -------------------------------------------------------------------------------------------- */
/* ------------------------------ Recupera Cuenta/ Nueva Contraseña --------------------------- */
/* -------------------------------------------------------------------------------------------- */

function leerformularioRecuperaCuenta(e){
    e.preventDefault();
    
    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const usuario = document.querySelector('#usuario').value,
        tipo = document.querySelector('#tipo').value;

    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('tipo', tipo);

    // crear el llamado a ajax
    const xhr = new XMLHttpRequest();

    // abrir la conexión.
    xhr.open('POST', 'inc/modelos/modelo-recupera-pwd.php', true);

    // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.nombre);                
                window.location.href = 'index.php?login=false';
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

function leerformularioNuevaPassword(e){
    e.preventDefault();
    
    // mandar ejecutar Ajax
    // datos que se envian al servidor
    const usuario = document.querySelector('#usuario').value,
        clave = document.querySelector('#clave').value,
        pwd = document.querySelector('#pwd').value,
        val_pwd = document.querySelector('#val_pwd').value,
        tipo = document.querySelector('#tipo').value;
    

    if (val_pwd !== pwd) {
        alert('Contraseñas no coinciden');
    } else {
        // Pasa la validacion, crear llamado a Ajax
        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('clave', clave);
        datos.append('pwd', pwd);
        datos.append('tipo', tipo);
        console.log(...datos)

        // crear el llamado a ajax
        const xhr = new XMLHttpRequest();
        // abrir la conexión.
        xhr.open('POST', 'inc/modelos/modelo-recupera-pwd.php', true);

        // retorno de datos
        xhr.onload = function() {
            if (this.status === 200) {
                // const respuesta = JSON.parse(xhr.responseText);
                // console.log(respuesta);
                console.log(xhr.responseText);

                // Si la respuesta es correcta
                if (respuesta.respuesta === 'correcto') {  
                    alert(respuesta.nombre+". Correo: "+respuesta.correo);                
                    window.location.href = 'index.php?login=false';
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
    
}