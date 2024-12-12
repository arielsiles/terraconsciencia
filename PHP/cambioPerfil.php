<?php
    session_start();
    $idUser = $_SESSION['id'];
    if(!empty($_FILES['imgChange'])){
        $nombreImagen = $_FILES['imgChange']['name'];
        $archivo = $_FILES['imgChange']['tmp_name'];
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
?>