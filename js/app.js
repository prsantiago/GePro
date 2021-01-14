const formularioProfesor = document.querySelector('#profesor');

eventListeners();

function eventListeners() {
    // Cuando el formulario profesor se ejecuta
    if(formularioProfesor)
        formularioProfesor.addEventListener('submit', leerFormularioProfesor);
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
        accion = document.querySelector('#accion').value;

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
        infoContacto.append('accion', accion);

        // console.log(...infoContacto);

        if (accion === 'crear') {
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