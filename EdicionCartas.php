<?php
    require "./PHP/direccionCartas.php";
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
        <link rel="stylesheet" href="../assets/CSS/styleEdicion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedorCrt">
        <h1>
            Suba las 9 imagenes a colocarse en el juego.
        </h1>
        <form action="./PHP/imagenesCartas.php" method="POST" enctype="multipart/form-data">
            <p>Imagen 1</p>
            <input type="file" accept="image/*" style="display: none;" id="image1" name="image1" onchange="javascript:previewImage(event, '#previewImg1')">
            <label for="image1" class="img">
                <img src="<?php echo $rutaImagen; ?>" alt="" width="300px" height="300px" id="previewImg1">
            </label>
            <p>Imagen 2</p>
            <input type="file" accept="image/*" style="display: none;" id="image2" name="image2" onchange="javascript:previewImage(event, '#previewImg2')">
            <label for="image2" class="img">
                <img src="<?php echo $rutaImagen2; ?>" alt="" width="300px" height="300px" id="previewImg2">
            </label>
            <p>Imagen 3</p>
            <input type="file" accept="image/*" style="display: none;" id="image3" name="image3" onchange="javascript:previewImage(event, '#previewImg3')">
            <label for="image3" class="img">
                <img src="<?php echo $rutaImagen3; ?>" alt="" width="300px" height="300px" id="previewImg3">
            </label>
            <p>Imagen 4</p>
            <input type="file" accept="image/*" style="display: none;" id="image4" name="image4" onchange="javascript:previewImage(event, '#previewImg4')">
            <label for="image4" class="img">
                <img src="<?php echo $rutaImagen4; ?>" alt="" width="300px" height="300px" id="previewImg4">
            </label>
            <p>Imagen 5</p>
            <input type="file" accept="image/*" style="display: none;" id="image5" name="image5" onchange="javascript:previewImage(event, '#previewImg5')">
            <label for="image5" class="img">
                <img src="<?php echo $rutaImagen5; ?>" alt="" width="300px" height="300px" id="previewImg5">
            </label>
            <p>Imagen 6</p>
            <input type="file" accept="image/*" style="display: none;" id="image6" name="image6" onchange="javascript:previewImage(event, '#previewImg6')">
            <label for="image6" class="img">
                <img src="<?php echo $rutaImagen6; ?>" alt="" width="300px" height="300px" id="previewImg6">
            </label>
            <p>Imagen 7</p>
            <input type="file" accept="image/*" style="display: none;" id="image7" name="image7" onchange="javascript:previewImage(event, '#previewImg7')">
            <label for="image7" class="img">
                <img src="<?php echo $rutaImagen7; ?>" alt="" width="300px" height="300px" id="previewImg7">
            </label>
            <p>Imagen 8</p>
            <input type="file" accept="image/*" style="display: none;" id="image8" name="image8" onchange="javascript:previewImage(event, '#previewImg8')">
            <label for="image8" class="img">
                <img src="<?php echo $rutaImagen8; ?>" alt="" width="300px" height="300px" id="previewImg8">
            </label>
            <p>Imagen 9</p>
            <input type="file" accept="image/*" style="display: none;" id="image9" name="image9" onchange="javascript:previewImage(event, '#previewImg9')">
            <label for="image9" class="img">
                <img src="<?php echo $rutaImagen9; ?>" alt="" width="300px" height="300px" id="previewImg9">
            </label>
            <br>
            <input type="submit">
        </form>
        <button onclick="mezclarOrden()">Mezclar orden</button>
        <button id="resetButton" onclick="resetCounters()">Restablecer Intentos</button>
        <a class="return" href="J1Adm.php">
            Volver 
        </a>
    </div>
    <script src="./JS/preview.js"></script>
    <script src="./JS/ordenCartas.js"></script>
    <script src="./JS/resetCountersCrt.js"></script>
</body>
</html>