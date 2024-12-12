<?php
    include "conexionBe.php";
    if (isset($_FILES['image_url']) && isset($_POST['section']) && isset($_POST['description']) && isset($_FILES['pdfFile'])){
        $section = $_POST['section'];
        $imageUrl = $_FILES['image_url']['name'];
        $nameImageUrl = $_FILES['image_url']['tmp_name'];
        $description = $_POST['description'];

        $pdfFileName = $_FILES['pdfFile']['name'];
        $pdfTempName = $_FILES['pdfFile']['tmp_name'];

        // Generar nombres únicos para los archivos
        //$timestamp = date('Ymd_His'); // Fecha y hora en formato YYYYMMDD_HHMMSS
        $imageExtension = getFileExtension($imageUrl);
        $pdfExtension = getFileExtension($pdfFileName);

        $uniqueImageName = date('Ymd_His') . '_' . uniqid() . '.' . $imageExtension;
        $uniquePdfName   = date('Ymd_His') . '_' . uniqid() . '.' . $pdfExtension;

        // Rutas para almacenar los archivos
        $rutaPdf = "../PDF/" . $uniquePdfName;
        $rutaImage = "../IMGUP/" . $uniqueImageName;


        //$rutaPdf = "../PDF";
        //$rutaPdf = $rutaPdf . "/" . $pdfFileName;
        
        //$ruta = "../IMGUP";
        //$ruta = $ruta . "/" . $imageUrl;

        //$nameRuta = "./PDF";
        //$nameRuta = $nameRuta . "/" . $pdfFileName;

        print("Imagen: " . $rutaImage);
        print("<br>");
        print("Documento: " . $rutaPdf);

        $ruta = $rutaImage;
        $nameRuta = $rutaPdf;

        if ($section == 'seccion1'){
            move_uploaded_file($nameImageUrl, $ruta);
            move_uploaded_file($pdfTempName, $rutaPdf);
            $query = "INSERT INTO seccionpb1 (dir_imagen, descripcion_pb, dir_pdf) VALUES ('$ruta', '$description', '$nameRuta')";
            header('Location: ../PublicacionesAdm.php');
        } elseif ($section == 'seccion2') {
            move_uploaded_file($nameImageUrl, $ruta);
            move_uploaded_file($pdfTempName, $rutaPdf);
            $query = "INSERT INTO seccionpb2 (dir_imagen, descripcion_pb, dir_pdf) VALUES ('$ruta', '$description', '$nameRuta')";
            header('Location: ../PublicacionesAdm.php');
        } elseif ($section == 'seccion3') {
            move_uploaded_file($nameImageUrl, $ruta);
            move_uploaded_file($pdfTempName, $rutaPdf);
            $query = "INSERT INTO seccionpb3 (dir_imagen, descripcion_pb, dir_pdf) VALUES ('$ruta', '$description', '$nameRuta')";
            header('Location: ../PublicacionesAdm.php');
        }
        mysqli_query($conexion, $query);
    }

// Función para normalizar nombres de archivo
function getFileExtension($filename) {
    return pathinfo($filename, PATHINFO_EXTENSION);
}
?>