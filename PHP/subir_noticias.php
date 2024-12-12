<?php
header('Content-Type: text/html; charset=utf-8');
include "conexionBe.php";

// Actualizar noticia destacada
if (isset($_POST['idNot'])) {
    $id_destacada = $_POST['idNot'];
    $queryUpdate = "UPDATE noticias SET noticia_destacada = 0 WHERE noticia_destacada = 1";
    mysqli_query($conexion, $queryUpdate);
    
    $queryDestacada = "UPDATE noticias SET noticia_destacada = 1 WHERE id_noticia = $id_destacada";
    mysqli_query($conexion, $queryDestacada);
    
    header("Location: ../NoticiasAdm.php");
}

// Insertar nueva noticia
if (isset($_FILES['imagenNoticia']) && isset($_POST['titulo']) && isset($_POST['completa']) && isset($_POST['descripcion'])) {
    $imagenNoticia = $_FILES['imagenNoticia']['name'];
    $archivoNt = $_FILES['imagenNoticia']['tmp_name'];
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $ntCompl = mysqli_real_escape_string($conexion, $_POST['completa']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    $ruta = "../IMGUP/" . $imagenNoticia;

    move_uploaded_file($archivoNt, $ruta);

    $queryInsert = "INSERT INTO noticias (titulo_noticia, imagen_noticia, descripcion_noticia, noticia_completa) VALUES ('$titulo','$ruta', '$descripcion', '$ntCompl')";
    if (mysqli_query($conexion, $queryInsert)) {
        header("Location: ../NoticiasAdm.php");
    } else {
        echo "Error en la consulta de inserción: " . mysqli_error($conexion);
    }
}
?>
