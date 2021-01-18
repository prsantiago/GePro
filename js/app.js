const formularioProfesor = document.querySelector('#profesor'),
        formularioAlumno = document.querySelector('#alumno');

eventListeners();

function eventListeners() {
    // Cuando el formulario profesor se ejecuta
    if(formularioProfesor)
        formularioProfesor.addEventListener('submit', leerFormularioProfesor);
    if(formularioAlumno)
        formularioAlumno.addEventListener('submit', leerFormularioAlumno);
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

    if (nombre_profesor === '' || apellido_profesor === '' || matricula_profesor === '' || correo_profesor === '' || valpass_profesor === '' ||
        password_profesor === '' || universidad_profesor === '' || division_profesor === '' || departamento_profesor=== '') {
        console.log('Todos los campos son obligatorios');
        // 2 parametros texto y clase
        // mostrarNotificacion('Todos los campos son obligatorios', 'error');
    } else if (valpass_profesor !== password_profesor) {
        console.log(password_profesor, valpass_profesor)
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
        infoContacto.append('accion_profesor', accion_profesor);

        // console.log(...infoContacto);

        if (accion_profesor === 'crear') {
            // crearemos un nuevo contacto
            insertarProfesorBD(infoContacto);
        } else {
            // editar el contacto
            // leer el id
            // const idRegistro = document.querySelector('#id').value;
            // infoContacto.append('id', idRegistro);
            // actualizaRegistro(infoContacto);
            console.log('TODO editar')
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
            console.log(respuesta)

            //Resetear el formulario
            document.querySelector('form').reset();

            // Mostar notificacion de completado
            // mostrarNotificacion('Contacto creado correctamente', 'correcto');
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

    if (nombre_alumno === '' || apellido_alumno === '' || matricula_alumno === '' || correo_alumno === '' || valpass_alumno === '' ||
        password_alumno === '' || universidad_alumno === '' || division_alumno === '' || carrera_alumno=== '' || estado_alumno === '') {
        console.log('Todos los campos son obligatorios');
        // 2 parametros texto y clase
        // mostrarNotificacion('Todos los campos son obligatorios', 'error');
    } else if (valpass_alumno !== password_alumno) {
        console.log('Contraseñas no coinciden');
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

        // console.log(estado_alumno[0]);
        // console.log(estado_alumno[1]);
        // console.log(estado_alumno);
        // console.log(...infoContacto);

        if (accion_alumno === 'crear') {
            // crearemos un nuevo contacto
            insertarAlumnoBD(infoContacto);
        } else {
            // editar el contacto
            // leer el id
            // const idRegistro = document.querySelector('#id').value;
            // infoContacto.append('id', idRegistro);
            // actualizaRegistro(infoContacto);
            console.log('TODO editar')
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
            console.log(respuesta)

            //Resetear el formulario
            document.querySelector('form').reset();

            // Mostar notificacion de completado
            // mostrarNotificacion('Contacto creado correctamente', 'correcto');
        }
    }

    // enviar los datos
    xhr.send(datos);
}