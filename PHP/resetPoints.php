<?php
    include "conexionBe.php";
    $query = "UPDATE usuarios SET puntos = 0";
    mysqli_query($conexion, $query);
    echo "Los puntos han sido restablecidos.";
    mysqli_close($conexion);
?>