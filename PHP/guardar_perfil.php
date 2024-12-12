<?php
    session_start();
    include "conexionBe.php";
    $idUser = $_SESSION['id'];
    if(!empty($_FILES['foto'])){
        $nombreImagen = $_FILES['foto']['name'];
        $archivo = $_FILES['foto']['tmp_name'];
        $ruta = "../IMGPR";
        $ruta = $ruta . "/" . $nombreImagen;
        move_uploaded_file($archivo, $ruta);
        $query = mysqli_query($conexion, "UPDATE usuarios SET perfil = '$ruta' WHERE id = '$idUser';");
        if ($query) {
            header('Location: ../PublicacionesAdm.php');
        } else {
            header('Location: ../TriviasAdm.php');
        }
    }
    if(!empty($_POST['nombre_usuario'])){
        $nombre_usuario = $_POST['nombre_usuario'];
        $sql = "UPDATE usuarios SET nombre_usuario ='$nombre_usuario'";
        mysqli_query($conexion, $sql);
    }
    if(!empty($_POST['nombres'])){
        $nombres = $_POST['nombres'];
        $sql2 = "UPDATE perfil SET nombres ='$nombres'";
        mysqli_query($conexion, $sql2);
    }
    if(!empty($_POST['apellidos'])){
        $apellidos = $_POST['apellidos'];
        $sql3 = "UPDATE perfil SET apellidos ='$apellidos'";
        mysqli_query($conexion, $sql3);
    }
    if(!empty($_POST['nacimiento'])){
        $fecha_nacimiento = $_POST['nacimiento'];
        $sql4 = "UPDATE perfil SET nacimiento ='$fecha_nacimiento'";
        mysqli_query($conexion, $sql4);
    }
    if(!empty($_POST['descripcion'])){
        $descripcion = $_POST['descripcion'];
        $sql5 = "UPDATE perfil SET descripcion ='$descripcion'";
        mysqli_query($conexion, $sql5);
    }
    header('Location: ../Cuenta.php');
?>