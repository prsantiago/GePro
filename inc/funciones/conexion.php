<?php

//Credenciales de la base de batos
define('DB_USUARIO', 'root');
define('DB_PASSWORD','');
define('DB_HOST','localhost');
define('DB_NOMBRE','gepro');

$conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);

// echo $conn->ping();

// if (!$conn) {
//     echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
//     echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
//     exit;
// }
// else {
// 	echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
// 	echo "Información del host: " . mysqli_get_host_info($conn) . PHP_EOL;

// }

// mysqli_close($conn);

?>