<?php
    include "conexionBe.php";
    $query = "UPDATE usuarios SET contadorFV = 0";
    mysqli_query($conexion, $query);
    echo "Los contadores se han reiniciado.";
    mysqli_close($conexion);
?>