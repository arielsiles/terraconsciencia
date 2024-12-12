<?php
header('Content-Type: text/html; charset=utf-8');
include 'conexionBe.php';

if (isset($_FILES['imagenPortada'])) {
    $nombreImagen = $_FILES['imagenPortada']['name'];
    $archivo = $_FILES['imagenPortada']['tmp_name'];
    $ruta = "../IMGUP";
    $ruta = $ruta . "/" . $nombreImagen;
}

if (isset($_FILES['imagenNoticias'])) {
    $nomImgNt = $_FILES['imagenNoticias']['name'];
    $archivoNt = $_FILES['imagenNoticias']['tmp_name'];
    $ruta2 = "../IMGUP";
    $ruta2 = $ruta2 . "/" . $nomImgNt;
}

if (isset($_FILES['imagenPublicaciones'])) {
    $nomImgPb = $_FILES['imagenPublicaciones']['name'];
    $archivoPb = $_FILES['imagenPublicaciones']['tmp_name'];
    $ruta3 = "../IMGUP";
    $ruta3 = $ruta3 . "/" . $nomImgPb;
}

if (isset($_FILES['imagenTrivias'])) {
    $nomImgTr = $_FILES['imagenTrivias']['name'];
    $archivoTr = $_FILES['imagenTrivias']['tmp_name'];
    $ruta4 = "../IMGUP";
    $ruta4 = $ruta4 . "/" . $nomImgTr;
}
$modal1 = mysqli_real_escape_string($conexion, $_POST["modif1"]);
$modal2 = $_POST["modif2"];
$modal3 = $_POST["modif3"];
$modal4 = $_POST["modif4"];
$modal5 = $_POST["modif5"];
$modal6 = $_POST["modif6"];
$modal7 = $_POST["modif7"];
$modal8 = $_POST["modif8"];
$modal9 = $_POST["modif9"];
$modal10 = $_POST["modif10"];
$modal11 = $_POST["modif11"];
$modal12 = $_POST["modif12"];
$modal13 = $_POST["modif13"];
$modal14 = $_POST["modif14"];
$modal15 = $_POST["modif15"];
$modal16 = $_POST["modif16"];
$modal17 = $_POST["modif17"];
$modal18 = $_POST["modif18"];

if (!empty($_POST["modif1"])) {
    $modal1 = $_POST["modif1"];
    $mod1 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal1' WHERE id= 1;");
    if ($mod1){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif2"])) {
    $modal2 = $_POST["modif2"];
    $mod2 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal2' WHERE id= 2;");
    if ($mod2){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif3"])) {
    $modal3 = $_POST["modif3"];
    $mod3 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal3' WHERE id= 3;");
    if ($mod3){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif4"])) {
    $modal4 = $_POST["modif4"];
    $mod4 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal4' WHERE id= 4;");
    if ($mod4){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif5"])) {
    $modal5 = $_POST["modif5"];
    $mod5 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal5' WHERE id= 5;");
    if ($mod5){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif6"])) {
    $modal6 = $_POST["modif6"];
    $mod6 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal6' WHERE id= 6;");
    if ($mod6){
        header("Location: ../EdicionConLogin.php");
    }
}
if (!empty($_POST["modif7"])) {
    $modal7 = $_POST["modif7"];
    $mod7 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal7' WHERE id= 7;");
    if ($mod7){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif8"])) {
    $modal8 = $_POST["modif8"];
    $mod8 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal8' WHERE id= 8;");
    if ($mod8){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif9"])) {
    $modal9 = $_POST["modif9"];
    $mod9 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal9' WHERE id= 9;");
    if ($mod9){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif10"])) {
    $modal10 = $_POST["modif10"];
    $mod10 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal10' WHERE id= 10;");
    if ($mod10){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif11"])) {
    $modal11 = $_POST["modif11"];
    $mod11 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal11' WHERE id= 11;");
    if ($mod11){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif12"])) {
    $modal12 = $_POST["modif12"];
    $mod12 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal12' WHERE id= 12;");
    if ($mod12){
        header("Location: ../SubirNoticias.php");
    }
}
if (!empty($_POST["modif13"])) {
    $modal13 = $_POST["modif13"];
    $mod13 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal13' WHERE id= 13;");
    if ($mod13){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif14"])) {
    $modal14 = $_POST["modif14"];
    $mod14 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal14' WHERE id= 14;");
    if ($mod14){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif15"])) {
    $modal15 = $_POST["modif15"];
    $mod15 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal15' WHERE id= 15;");
    if ($mod15){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif16"])) {
    $modal16 = $_POST["modif16"];
    $mod16 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal16' WHERE id= 16;");
    if ($mod16){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif17"])) {
    $modal17 = $_POST["modif17"];
    $mod17 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal17' WHERE id= 17;");
    if ($mod17){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif18"])) {
    $modal18 = $_POST["modif18"];
    $mod18 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal18' WHERE id= 18;");
    if ($mod18){
        header("Location: ../SubirPublicacion.php");
    }
}
if (!empty($_POST["modif19"])) {
    $modal19 = $_POST["modif19"];
    $mod19 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal19' WHERE id= 19;");
    if ($mod19){
        header("Location: ../EdicionTest.php");
    }
}
if (!empty($_POST["modif20"])) {
    $modal20 = $_POST["modif20"];
    $mod20 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal20' WHERE id= 20;");
    if ($mod20){
        header("Location: ../EdicionTest.php");
    }
}
if (!empty($_POST["modif21"])) {
    $modal21 = $_POST["modif21"];
    $mod21 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal21' WHERE id= 21;");
    if ($mod21){
        header("Location: ../EdicionTest.php");
    }
}
if (!empty($_POST["modif22"])) {
    $modal22 = $_POST["modif22"];
    $mod22 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal22' WHERE id= 22;");
    if ($mod22){
        header("Location: ../EdicionTest.php");
    }
}
if (!empty($_POST["modif23"])) {
    $modal23 = $_POST["modif23"];
    $mod23 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal23' WHERE id= 23;");
    if ($mod23){
        header("Location: ../EdicionTest.php");
    }
}
if (!empty($_POST["modif24"])) {
    $modal24 = $_POST["modif24"];
    $mod24 = mysqli_query($conexion, "UPDATE popups SET descripcion = '$modal24' WHERE id= 24;");
    if ($mod24){
        header("Location: ../EdicionTest.php");
    }
}



if (isset($_FILES['imagenPortada']) && $_FILES['imagenPortada']['error'] == 0) {
    move_uploaded_file($archivo, $ruta);
    $query = mysqli_query($conexion, "UPDATE imagenes SET imagen = '$ruta', nombre = '$nombreImagen' WHERE id_imagen = 1;");
    if ($query) {
        header("Location: ../EdicionConLogin.php");
    } else {
        echo "Hubo un error al actualizar la imagen.";
    }
}

if (isset($_FILES['imagenNoticias']) && $_FILES['imagenNoticias']['error'] == 0) {
    move_uploaded_file($archivoNt, $ruta2);
    $query2 = mysqli_query($conexion, "UPDATE imagenes SET imagen = '$ruta2', nombre = '$nomImgNt' WHERE id_imagen = 2;");
    if ($query2) {
        header("Location: ../EdicionConLogin.php");
    } else {
        echo "Hubo un error al actualizar la imagen.";
    }
}

if (isset($_FILES['imagenPublicaciones']) && $_FILES['imagenPublicaciones']['error'] == 0) {
    move_uploaded_file($archivoPb, $ruta3);
    $query3 = mysqli_query($conexion, "UPDATE imagenes SET imagen = '$ruta3', nombre = '$nomImgPb' WHERE id_imagen = 3;");
    if ($query3) {
        header("Location: ../EdicionConLogin.php");
    } else {
        echo "Hubo un error al actualizar la imagen.";
    }
}

if (isset($_FILES['imagenTrivias']) && $_FILES['imagenTrivias']['error'] == 0) {
    move_uploaded_file($archivoTr, $ruta4);
    $query4 = mysqli_query($conexion, "UPDATE imagenes SET imagen = '$ruta4', nombre = '$nomImgTr' WHERE id_imagen = 4;");
    if ($query4) {
        header("Location: ../EdicionConLogin.php");
    } else {
        echo "Hubo un error al actualizar la imagen.";
    }
}

mysqli_close($conexion);
?>
