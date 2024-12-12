<?php
    include 'conexionBe.php';

    $query = "SELECT palabra FROM palabras_ahorcados";
    $result = mysqli_query($conexion, $query);

    $words = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $words[] = $row['palabra'];
    }

    echo json_encode($words);
?>