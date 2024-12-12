<?php
    include 'conexionBe.php';
    
    if (!empty($_POST['plb1'])){
        $plb1 = $_POST['plb1'];
        $query = mysqli_query($conexion, "UPDATE palabras_ahorcados SET palabra = '$plb1' WHERE id= 1;");
        if ($query){
            header("Location: ../actualizarPalabras.php");
        }
    }
    if (!empty($_POST['plb2'])){
        $plb2 = $_POST['plb2'];
        $query2 = mysqli_query($conexion, "UPDATE palabras_ahorcados SET palabra = '$plb2' WHERE id= 2;");
        if ($query2){
            header("Location: ../actualizarPalabras.php");
        }
    }
    if (!empty($_POST['plb3'])){
        $plb3 = $_POST['plb3'];
        $query3 = mysqli_query($conexion, "UPDATE palabras_ahorcados SET palabra = '$plb3' WHERE id= 3;");
        if ($query3){
            header("Location: ../actualizarPalabras.php");
        }
    }
    if (!empty($_POST['plb4'])){
        $plb4 = $_POST['plb4'];
        $query4 = mysqli_query($conexion, "UPDATE palabras_ahorcados SET palabra = '$plb4' WHERE id= 4;");
        if ($query4){
            header("Location: ../actualizarPalabras.php");
        }
    }
    if (!empty($_POST['plb5'])){
        $plb5 = $_POST['plb5'];
        $query5 = mysqli_query($conexion, "UPDATE palabras_ahorcados SET palabra = '$plb5' WHERE id= 5;");
        if ($query5){
            header("Location: ../actualizarPalabras.php");
        }
    }
?>