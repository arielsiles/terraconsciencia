<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./PHP/conexionBe.php";

   require "./PHP/direccionSeleccion.php";
session_start();
$roles_permitidos = ['Administrador'];

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ConLogin.php");
    exit(); // Asegura que el script se detenga después de redirigir
}
$directorio_destino = "./uploads/";
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
    <div class="contenedorSeleccion">
        <h1>Modifica los titulos de cada contenedor</h1>
        <form action="./PHP/imagenesSeleccion.php" method="POST">
            <p>Contenedor 1: *azules</p>
            <input type="text" placeholder="Nombre del contenedor de la imagen 1-6" style="width: 290px;" name="cont1">
            <p>Contenedor 2: *rojos</p>
            <input type="text" placeholder="Nombre del contenedor de la imagen 7-12" style="width: 290px;" name="cont2"><br>
            <input type="submit">
        </form>
        <h1>
            Suba las imagenes a colocarse en el juego.
        </h1>
        <form action="./PHP/imagenesSeleccion.php" method="POST" enctype="multipart/form-data">
            <div class="contenedorSel1">
                <h2>CONTENEDOR 1:</h2>
                <p>Imagen 1</p>
                <input type="file" accept="image/*" style="display: none;" id="image1" name="image1" onchange="javascript:previewImage(event, '#previewImg1')">
                <label for="image1" class="img">
                    <img src="<?php echo $rutas[0]; ?>" alt="" width="300px" height="300px" id="previewImg1">
                </label>
                <p>Imagen 2</p>
                <input type="file" accept="image/*" style="display: none;" id="image2" name="image2" onchange="javascript:previewImage(event, '#previewImg2')">
                <label for="image2" class="img">
                    <img src="<?php echo $rutas[1]; ?>" alt="" width="300px" height="300px" id="previewImg2">
                </label>
                <p>Imagen 3</p>
                <input type="file" accept="image/*" style="display: none;" id="image3" name="image3" onchange="javascript:previewImage(event, '#previewImg3')">
                <label for="image3" class="img">
                    <img src="<?php echo $rutas[2]; ?>" alt="" width="300px" height="300px" id="previewImg3">
                </label>
                <p>Imagen 4</p>
                <input type="file" accept="image/*" style="display: none;" id="image4" name="image4" onchange="javascript:previewImage(event, '#previewImg4')">
                <label for="image4" class="img">
                    <img src="<?php echo $rutas[3]; ?>" alt="" width="300px" height="300px" id="previewImg4">
                </label>
                <p>Imagen 5</p>
                <input type="file" accept="image/*" style="display: none;" id="image5" name="image5" onchange="javascript:previewImage(event, '#previewImg5')">
                <label for="image5" class="img">
                    <img src="<?php echo $rutas[4]; ?>" alt="" width="300px" height="300px" id="previewImg5">
                </label>
                <p>Imagen 6</p>
                <input type="file" accept="image/*" style="display: none;" id="image6" name="image6" onchange="javascript:previewImage(event, '#previewImg6')">
                <label for="image6" class="img">
                    <img src="<?php echo $rutas[5]; ?>" alt="" width="300px" height="300px" id="previewImg6">
                </label>
            </div>
            <br><br><br>
            <div class="contenedorSel2">
                <h2>CONTENEDOR 2:</h2>
                <p>Imagen 1</p>
                <input type="file" accept="image/*" style="display: none;" id="image7" name="image7" onchange="javascript:previewImage(event, '#previewImg7')">
                <label for="image7" class="img">
                    <img src="<?php echo $rutas[6]; ?>" alt="" width="300px" height="300px" id="previewImg7">
                </label>
                <p>Imagen 2</p>
                <input type="file" accept="image/*" style="display: none;" id="image8" name="image8" onchange="javascript:previewImage(event, '#previewImg8')">
                <label for="image8" class="img">
                    <img src="<?php echo $rutas[7]; ?>" alt="" width="300px" height="300px" id="previewImg8">
                </label>
                <p>Imagen 3</p>
                <input type="file" accept="image/*" style="display: none;" id="image9" name="image9" onchange="javascript:previewImage(event, '#previewImg9')">
                <label for="image9" class="img">
                    <img src="<?php echo $rutas[8]; ?>" alt="" width="300px" height="300px" id="previewImg9">
                </label>
                <p>Imagen 4</p>
                <input type="file" accept="image/*" style="display: none;" id="image10" name="image10" onchange="javascript:previewImage(event, '#previewImg10')">
                <label for="image10" class="img">
                    <img src="<?php echo $rutas[9]; ?>" alt="" width="300px" height="300px" id="previewImg10">
                </label>
                <p>Imagen 5</p>
                <input type="file" accept="image/*" style="display: none;" id="image11" name="image11" onchange="javascript:previewImage(event, '#previewImg11')">
                <label for="image11" class="img">
                    <img src="<?php echo $rutas[10]; ?>" alt="" width="300px" height="300px" id="previewImg11">
                </label>
                <p>Imagen 6</p>
                <input type="file" accept="image/*" style="display: none;" id="image12" name="image12" onchange="javascript:previewImage(event, '#previewImg12')">
                <label for="image12" class="img">
                    <img src="<?php echo $rutas[11]; ?>" alt="" width="300px" height="300px" id="previewImg12">
                </label>
            </div>
            <br>
            <input type="submit">
        </form>
        <button id="resetButton" onclick="resetCounters()">Restablecer Intentos</button>
        <a class="return" href="J5Adm.php">
            Volver 
        </a>
    </div>
    <script src="./JS/preview.js"></script>
    <script src="./JS/resetCountersSeleccion.js"></script>
</body>
</html>