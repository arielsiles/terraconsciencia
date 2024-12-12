<?php
    include 'PHP/conexionBe.php';
    $sql = "SELECT imagen FROM imagenes WHERE id_imagen = '1'";
    $resultado = $conexion -> query($sql);
    $row = $resultado -> fetch_assoc();
    $rutaImagen = str_replace('../', './', $row['imagen']);

    $sql2 = "SELECT imagen FROM imagenes WHERE id_imagen = '2'";
    $resultado2 = $conexion -> query($sql2);
    $row2 = $resultado2 -> fetch_assoc();
    $rutaImagen2 = str_replace('../', './', $row2['imagen']);

    $sql3 = "SELECT imagen FROM imagenes WHERE id_imagen = '3'";
    $resultado3 = $conexion -> query($sql3);
    $row3 = $resultado3 -> fetch_assoc();
    $rutaImagen3 = str_replace('../', './', $row3['imagen']);

    $sql4 = "SELECT imagen FROM imagenes WHERE id_imagen = '4'";
    $resultado4 = $conexion -> query($sql4);
    $row4 = $resultado4 -> fetch_assoc();
    $rutaImagen4 = str_replace('../', './', $row4['imagen']);
?>