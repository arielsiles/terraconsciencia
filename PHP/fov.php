<?php
    include './PHP/conexionBe.php';
    $sql = "SELECT * FROM falsoverdadero";
    $resultado = $conexion -> query($sql);
    $titulo = array();
    $fov = array();
    $afirmaciones = array();
    while ($row = $resultado -> fetch_assoc()) {
        $titulo[] = $row['titulo'];
        $afirmaciones[] = $row["pregunta"];
        $fov[] = $row['fov'];
    }
?>