<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include "./PHP/popups.php";
    include "./PHP/fov.php";
    $roles_permitidos = ['Administrador','Usuario','Docente'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } /*else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J4Adm.php");
        }
    }*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <link href="http://fonts.cdnfonts.com/css/sf-pixelate" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/styleJgs.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/styleJ4.css">

</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div class="cuerpo">

                    <div class="centroRmp">
                        <h1>¡Ahorcados!</h1>
                        <h3>Adivina la palabra... o muere </h3>
                        <div>
                            <canvas id="canvas"></canvas>
                            <div id="usedLetters"></div>
                        </div>
                        <div id="wordContainer"></div>
                        <button id="startButton">START</button>
                    </div>
                </div>

                <div class="lado1 mt-3">
                    <a href="Trivias.php" class="btnBack">
                        <i class="fas fa-arrow-left"></i> Volver Atrás
                    </a>
                    </a>
                </div>



            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/click-scroll.js"></script>
<!--<script src="js/counter.js"></script>-->
<!--<script src="js/custom.js"></script>-->

<script src="JS/scripJgs.js"></script>

</body>

</html>