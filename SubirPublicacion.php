<?php
    header('Content-Type: text/html; charset=utf-8');
    require "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: ConLogin.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
        <title>Edicion</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="./assets/CSS/styleEdicion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedorPb">
        <div class="envioPb">
            <h2>Crear publicacion para el primer carrusel</h2>
            <form action="./PHP/crear_publicacion.php" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="section" value="seccion1">
                <input type="file" accept="image/*" name="image_url" id="imagenPb" style="display: none;" onchange="javascript:previewImage(event, '#previewImgPb')" required >
                <label for="imagenPb">
                    <img src="./IMG/imagenCamara.jpg" alt="" width="300px" height="300px" id="previewImgPb">
                </label>
                <!-- Input para PDF -->
                <input type="file" accept=".pdf" name="pdfFile" id="pdfFile" style="display: none;" required >
                <label for="pdfFile" style="border-style: dashed; margin: 5px 5px 5px 5px; background-color:aquamarine; font-size: 25px;">
                    Subir PDF
                </label>
                <!-- -->
                <input type="text" name="description" maxlength="200" placeholder="Descripción" style="width: 550px;">

                <p>Maximo 200 caracteres.</p>
                <button type="submit">Agregar publicación</button>
            </form>
        </div>
        <div class="envioPb">
        <h2>Crear publicacion para el segundo carrusel</h2>
            <form action="./PHP/crear_publicacion.php" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="section" value="seccion2">
                <input type="file" accept="image/*" name="image_url" id="imagenPb1" style="display: none;" onchange="javascript:previewImage(event, '#previewImgPb1')" required >
                <label for="imagenPb1">
                    <img src="./IMG/imagenCamara.jpg" alt="" width="300px" height="300px" id="previewImgPb1">
                </label>
                <!-- Input para PDF -->
                <input type="file" accept=".pdf" name="pdfFile" id="pdfFile1" style="display: none;" required >
                <label for="pdfFile1" style="border-style: dashed; margin: 5px 5px 5px 5px; background-color:aquamarine; font-size: 25px;">
                    Subir PDF
                </label>
                <!-- -->
                <input type="text" name="description" placeholder="Descripción" style="width: 550px;">
                <p>Maximo 200 caracteres.</p>
                <button type="submit">Agregar publicación</button>
            </form>
        </div>
        <div class="envioPb">
        <h2>Crear publicacion para el tercer carrusel</h2>
            <form action="./PHP/crear_publicacion.php" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="section" value="seccion3">
                <input type="file" accept="image/*" name="image_url" id="imagenPb2" style="display: none;" onchange="javascript:previewImage(event, '#previewImgPb2')" required >
                <label for="imagenPb2">
                    <img src="./IMG/imagenCamara.jpg" alt="" width="300px" height="300px" id="previewImgPb2">
                </label>
                <!-- Input para PDF -->
                <input type="file" accept=".pdf" name="pdfFile" id="pdfFile2" style="display: none;" required >
                <label for="pdfFile2" style="border-style: dashed; margin: 5px 5px 5px 5px; background-color:aquamarine; font-size: 25px;">
                    Subir PDF
                </label>
                <!-- -->
                <input type="text" name="description" placeholder="Descripción" style="width: 550px;">
                <p>Maximo 200 caracteres.</p>
                <button type="submit">Agregar publicación</button>
            </form>
        </div>
        <h2>Edita los mensajes de los popups: </h2>
        <h3>Maximo 130 caracteres.</h3>
        <form action="./PHP/subidaCl.php" method="POST" class="popups">
            <p>Modal 1:</p>
            <input type="text" class="modal" name="modif13" placeholder="<?php echo $descripciones[12]?>">
            <p>Modal 2:</p>
            <input type="text" class="modal" name="modif14" placeholder="<?php echo $descripciones[13]?>">
            <p>Modal 3:</p>
            <input type="text" class="modal" name="modif15" placeholder="<?php echo $descripciones[14]?>">
            <p>Modal 4:</p>
            <input type="text" class="modal" name="modif16" placeholder="<?php echo $descripciones[15]?>">
            <p>Modal 5:</p>
            <input type="text" class="modal" name="modif17" placeholder="<?php echo $descripciones[16]?>">
            <p>Modal 6:</p>
            <input type="text" class="modal" name="modif18" placeholder="<?php echo $descripciones[17]?>">
            <input type="submit" value="Modificar" id="subModPpPb" style="display: none;">
            <label for="subModPpPb" class="botonPortada" ><i class="fas fa-thumbs-up"></i></label>
        </form>

        <!--<a class="return" href="PublicacionesAdm.php">Volver</a>-->
        <a class="return" href="ConLogin.php">Volver</a>

    </div>
    <script src="./JS/preview.js"></script>
</body>
</html>