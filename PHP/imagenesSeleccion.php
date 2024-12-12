<?php
include "conexionBe.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);
if ($query) {
    header("Location: ../cambiarImagenesContenedor.php");
} else {
    echo "Hubo un error al ejecutar la consulta: " . mysqli_error($conexion);
}
if (isset($query) && $query) {
    header("Location: ../cambiarImagenesContenedor.php");
} else {
    echo "La consulta no se ejecutó correctamente.";
}

include "conexionBe.php";
if(!empty($_POST['cont1'])){
    $cont1 = $_POST['cont1'];
    $query = mysqli_query($conexion, "UPDATE falsoverdadero SET pregunta = '$cont1' WHERE id = 7;");
    if($query){
        header("Location: ../cambiarImagenesContenedor.php");
    }
}
if(!empty($_POST['cont2'])){
    $cont2 = $_POST['cont2'];
    $query2 = mysqli_query($conexion, "UPDATE falsoverdadero SET titulo = '$cont2' WHERE id = 7;");
}
function moveAndRenameImage($file, $newName, $destinationFolder) {
    $newFilePath = $destinationFolder . "/" . $newName;
    if (move_uploaded_file($file, $newFilePath)) {
        return $newFilePath;
    } else {
        return false;
    }
}
for ($i = 1; $i <= 12; $i++) {
    $fieldName = "image" . $i;

    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == 0) {
        $nombreImagen = $_FILES[$fieldName]['name'];
        $archivo = $_FILES[$fieldName]['tmp_name'];
        $ruta = "../IMGUP";
        $nuevoNombreImagen = $nombreImagen . "-azul";
        $nuevaRuta = moveAndRenameImage($archivo, $nuevoNombreImagen, $ruta);
        
        if ($nuevaRuta) {
            $idToUpdate = $i;
            $nuevaRuta = str_replace('../', './', $nuevaRuta);
            $query = mysqli_query($conexion, "UPDATE img_ord SET ruta = '$nuevaRuta' WHERE id = $idToUpdate;");
            if ($query) {
                header("Location: ../cambiarImagenesContenedor.php");
            } else {
                echo "Hubo un error al actualizar la imagen.";
            }
        } else {
            echo "Hubo un error al mover la imagen.";
        }
    }
}
?>
