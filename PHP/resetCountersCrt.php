<?php
    include "conexionBe.php";
    $query = "UPDATE usuarios SET contadorCrt = 0";
    mysqli_query($conexion, $query);
    echo "Los contadores se han reiniciado.";
    mysqli_close($conexion);
?>