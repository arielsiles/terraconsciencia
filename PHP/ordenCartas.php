<?php
    include "conexionBe.php";
    $consulta = "SELECT id, orden FROM orden_cartas";
    $resultado = mysqli_query($conexion, $consulta);
    $orden = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $orden[$fila['id']] = $fila['orden'];
    }
    shuffle($orden);
    foreach ($orden as $id => $valorOrden) {
        $consulta = "UPDATE orden_cartas SET orden = '$valorOrden' WHERE id = '$id'";
        mysqli_query($conexion, $consulta);
    }
    mysqli_close($conexion);
?>
