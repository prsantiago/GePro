<?php include 'inc/templates/header.php'; include 'inc/funciones/funciones.php';?>

<div class="">
    <div class="contenedor barra">
        <?php include 'inc/templates/logos.php'; ?>

        <a href="nuevo-proyecto.php">Nuevo proyecto</a>

        <div class="contenedor-usuario">
            <p>Hola, usuario</p>
        </div>
    </div>
</div>

<div class="bg-blanco contenedor sombra proyectos">
    <div class="contenedor-proyectos">
        <p class="total-proyectos"><span>2</span> Proyectos</p>

        <div class="contenedor-tabla">
            <table id="listado-proyectos" class="listado-proyectos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estudiante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PANL-015</td>
                        <td>Seminario de Integracion de Ing. en Computación 15</td>
                        <td>Nombre Apellido Apellido</td>
                        <td>
                            <a class="btn-check btn" href="progreso.php">
                                <i class="fas fa-user-check"></i>
                            </a>
                            <a class="btn-editar btn" href="editar-proyecto.php">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button data-id="" type="button" class="btn-borrar btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>TANL-016</td>
                        <td>Proyecto de Integracion de Ing. en Computación 16</td>
                        <td>Nombre Nombre Apellido Apellido</td>
                        <td>
                            <a class="btn-check btn" href="progreso.php">
                                <i class="fas fa-user-check"></i>
                            </a>
                            <a class="btn-editar btn" href="editar-proyecto.php">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button data-id="" type="button" class="btn-borrar btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'inc/templates/footer.php'; ?>