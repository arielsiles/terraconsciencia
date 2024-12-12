<?php
    include "conexionBe.php";
    if (isset($_FILES['image1'])) {
        $nombreImagen = $_FILES['image1']['name'];
        $archivo = $_FILES['image1']['tmp_name'];
        $ruta = "../IMGUP";
        $ruta = $ruta . "/" . $nombreImagen;
    }
    if (isset($_FILES['image2'])) {
        $nombreImagen2 = $_FILES['image2']['name'];
        $archivo2 = $_FILES['image2']['tmp_name'];
        $ruta2 = "../IMGUP";
        $ruta2 = $ruta2 . "/" . $nombreImagen2;
    }
    if (isset($_FILES['image3'])) {
        $nombreImagen3 = $_FILES['image3']['name'];
        $archivo3 = $_FILES['image3']['tmp_name'];
        $ruta3 = "../IMGUP";
        $ruta3 = $ruta3 . "/" . $nombreImagen3;
    }
    if (isset($_FILES['image4'])) {
        $nombreImagen4 = $_FILES['image4']['name'];
        $archivo4 = $_FILES['image4']['tmp_name'];
        $ruta4 = "../IMGUP";
        $ruta4 = $ruta4 . "/" . $nombreImagen4;
    }
    if (isset($_FILES['image5'])) {
        $nombreImagen5 = $_FILES['image5']['name'];
        $archivo5 = $_FILES['image5']['tmp_name'];
        $ruta5 = "../IMGUP";
        $ruta5 = $ruta5 . "/" . $nombreImagen5;
    }
    if (isset($_FILES['image6'])) {
        $nombreImagen6 = $_FILES['image6']['name'];
        $archivo6 = $_FILES['image6']['tmp_name'];
        $ruta6 = "../IMGUP";
        $ruta6 = $ruta6 . "/" . $nombreImagen6;
    }
    if (isset($_FILES['image7'])) {
        $nombreImagen7 = $_FILES['image7']['name'];
        $archivo7 = $_FILES['image7']['tmp_name'];
        $ruta7 = "../IMGUP";
        $ruta7 = $ruta7 . "/" . $nombreImagen7;
    }
    if (isset($_FILES['image8'])) {
        $nombreImagen8 = $_FILES['image8']['name'];
        $archivo8 = $_FILES['image8']['tmp_name'];
        $ruta8 = "../IMGUP";
        $ruta8 = $ruta8 . "/" . $nombreImagen8;
    }
    if (isset($_FILES['image9'])) {
        $nombreImagen9 = $_FILES['image9']['name'];
        $archivo9 = $_FILES['image9']['tmp_name'];
        $ruta9 = "../IMGUP";
        $ruta9 = $ruta9 . "/" . $nombreImagen9;
    }
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] == 0) {
        move_uploaded_file($archivo, $ruta);
        $query = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta', nombre = '$nombreImagen' WHERE id = 1 OR id = 2;");
        if ($query) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] == 0) {
        move_uploaded_file($archivo2, $ruta2);
        $query2 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta2', nombre = '$nombreImagen2' WHERE id = 3 OR id = 4;");
        if ($query2) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image3']) && $_FILES['image3']['error'] == 0) {
        move_uploaded_file($archivo3, $ruta3);
        $query3 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta3', nombre = '$nombreImagen3' WHERE id = 5 OR id = 6;");
        if ($query3) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image4']) && $_FILES['image4']['error'] == 0) {
        move_uploaded_file($archivo4, $ruta4);
        $query4 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta4', nombre = '$nombreImagen4' WHERE id = 7 OR id = 8;");
        if ($query4) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image5']) && $_FILES['image5']['error'] == 0) {
        move_uploaded_file($archivo5, $ruta5);
        $query5 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta5', nombre = '$nombreImagen5' WHERE id = 9 OR id = 10;");
        if ($query5) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image6']) && $_FILES['image6']['error'] == 0) {
        move_uploaded_file($archivo6, $ruta6);
        $query6 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta6', nombre = '$nombreImagen6' WHERE id = 11 OR id = 12;");
        if ($query6) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image7']) && $_FILES['image7']['error'] == 0) {
        move_uploaded_file($archivo7, $ruta7);
        $query7 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta7', nombre = '$nombreImagen7' WHERE id = 13 OR id = 14;");
        if ($query7) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image8']) && $_FILES['image8']['error'] == 0) {
        move_uploaded_file($archivo8, $ruta8);
        $query8 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta8', nombre = '$nombreImagen8' WHERE id = 15 OR id = 16;");
        if ($query8) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
    if (isset($_FILES['image9']) && $_FILES['image9']['error'] == 0) {
        move_uploaded_file($archivo9, $ruta9);
        $query9 = mysqli_query($conexion, "UPDATE orden_cartas SET rutaImagen = '$ruta9', nombre = '$nombreImagen9' WHERE id = 17 OR id = 18;");
        if ($query9) {
            header("Location: ../EdicionCartas.php");
        } else {
            echo "Hubo un error al actualizar la imagen.";
        }
    }
?>