<?php
    include "conexionBe.php";
    $consulta = "SELECT id, fov FROM falsoverdadero WHERE id IN (1, 2, 3, 4, 5)";
    $resultado = mysqli_query($conexion, $consulta);
    $fov = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $fov[$fila['id']] = $fila['fov'];
    }
    mysqli_close($conexion);
    echo json_encode($fov);
?>
