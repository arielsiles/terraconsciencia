<?php

//$conexion = mysqli_connect('localhost', 'terracon_Terra', 'Pacha_2204', 'terracon_terraConsciente');
//$conexion = mysqli_connect('localhost', 'admin', 'mysql.1315', 'terracons', '3310');
//$conexion = mysqli_connect('10.0.0.106', 'admin', 'Mysql.1315', 'terracons', '3306');
$conexion = mysqli_connect('localhost', 'terra', 'Miracula.1315$', 'terracons', '3306');

if ($conexion) {
    // Configurar charset UTF-8 para evitar problemas de codificación
    mysqli_set_charset($conexion, "utf8mb4");
    //conexion estable
} else {
    // No mostrar mensaje al usuario
}

?>
