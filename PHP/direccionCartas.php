<?php
    include 'PHP/conexionBe.php';
    $sql = "SELECT rutaImagen FROM orden_cartas WHERE id = '1'";
    $resultado = $conexion -> query($sql);
    $row = $resultado -> fetch_assoc();
    $rutaImagen = str_replace('../', './', $row['rutaImagen']);

    $sql2 = "SELECT rutaImagen FROM orden_cartas WHERE id = '3'";
    $resultado2 = $conexion -> query($sql2);
    $row2 = $resultado2 -> fetch_assoc();
    $rutaImagen2 = str_replace('../', './', $row2['rutaImagen']);

    $sql3 = "SELECT rutaImagen FROM orden_cartas WHERE id = '5'";
    $resultado3 = $conexion -> query($sql3);
    $row3 = $resultado3 -> fetch_assoc();
    $rutaImagen3 = str_replace('../', './', $row3['rutaImagen']);

    $sql4 = "SELECT rutaImagen FROM orden_cartas WHERE id = '7'";
    $resultado4 = $conexion -> query($sql4);
    $row4 = $resultado4 -> fetch_assoc();
    $rutaImagen4 = str_replace('../', './', $row4['rutaImagen']);
    
    $sql5 = "SELECT rutaImagen FROM orden_cartas WHERE id = '9'";
    $resultado5 = $conexion -> query($sql5);
    $row5 = $resultado5 -> fetch_assoc();
    $rutaImagen5 = str_replace('../', './', $row5['rutaImagen']);

    $sql6 = "SELECT rutaImagen FROM orden_cartas WHERE id = '11'";
    $resultado6 = $conexion -> query($sql6);
    $row6 = $resultado6 -> fetch_assoc();
    $rutaImagen6 = str_replace('../', './', $row6['rutaImagen']);

    $sql7 = "SELECT rutaImagen FROM orden_cartas WHERE id = '13'";
    $resultado7 = $conexion -> query($sql7);
    $row7 = $resultado7 -> fetch_assoc();
    $rutaImagen7 = str_replace('../', './', $row7['rutaImagen']);

    $sql8 = "SELECT rutaImagen FROM orden_cartas WHERE id = '15'";
    $resultado8 = $conexion -> query($sql8);
    $row8 = $resultado8 -> fetch_assoc();
    $rutaImagen8 = str_replace('../', './', $row8['rutaImagen']);

    $sql9 = "SELECT rutaImagen FROM orden_cartas WHERE id = '17'";
    $resultado9 = $conexion -> query($sql9);
    $row9 = $resultado9 -> fetch_assoc();
    $rutaImagen9 = str_replace('../', './', $row9['rutaImagen']);
?>