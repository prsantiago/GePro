<?php

//Credenciales de la base de batos
define('DB_USUARIO', 'root');
define('DB_PASSWORD','');
define('DB_HOST','localhost');
define('DB_NOMBRE','gepro');

$conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);

?>