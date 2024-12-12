<?php
    include "conexionBe.php";
    $preguntas = $_POST["pregunta"];
    $respuestasBuenas = $_POST["respuestaBuena"];
    $respuestasMalas = $_POST["respuestaMala"];

    for ($i = 0; $i < count($preguntas); $i++) {
        $id = $i + 1; 
        $pregunta = $preguntas[$i];
        $respuestaBuena = $respuestasBuenas[$i];
        $respuestaMala = $respuestasMalas[$i];

        $sql = "UPDATE juego_avion SET mensajesPrevios = '$pregunta', mensajesBuenos = '$respuestaBuena', mensajesMalos = '$respuestaMala' WHERE id = $id";

        if ($conexion->query($sql) === TRUE) {
            header('Location: ../J6.php');
        }
    }
?>