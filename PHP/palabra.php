<?php
    include './PHP/conexionBe.php';
    $sql = "SELECT palabra FROM palabras_ahorcados";
    $resultado = $conexion -> query($sql);
    $descripciones = array();
    while ($row = $resultado -> fetch_assoc()) {
        $palabra[] = $row["palabra"];
    }
?>