<?php
header('Content-Type: text/html; charset=utf-8');
require "./PHP/popups.php";
require "./PHP/direcciones.php";
session_start();
$roles_permitidos = ['Administrador','Usuario','Docente'];
if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
    header("Location: SinLogin.php");
    session_destroy();
    die();
} /*else {
    if ($_SESSION['rol'] == 'Administrador') {
        header("Location: ConLoginAdm.php");
    }
}*/

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
    <!--<link rel="stylesheet" href="assets/CSS/styleSl.css">-->
    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

</head>

<body id="section_1">

<?php include 'header_info.php'; ?>

<?php include 'modal_cierre.php'; ?>

<!-- Menu -->
<?php include 'main_menu_user.php'; ?>

<main>

    <section class="home-header-section text-center">
        <!--<div class="section-overlay"></div>-->

        <div class="container">
            <div class="row">

                <!--<div class="col-lg-12 col-12">
                    <h1 class="text-white">&nbsp;</h1>
                </div>-->

            </div>
        </div>
    </section>

    <section class="section-padding-home">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <!--<div class="col-lg-10 col-12 text-center mx-auto">
                    <h2 class="mb-5">Bienvenida/o a esta nueva aventura</h2>
                </div>-->

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="CalculadoraInicio.html" class="d-block">
                            <img src="images/icons/op1_calculadora.png" class="featured-block-image img-fluid" alt="">
                            <p class="featured-block-text"><strong>Calculadora Hídrica</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="Noticias.php" class="d-block">
                            <img src="images/icons/op2_noticias.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Noticias</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="Publicaciones.php" class="d-block">
                            <img src="images/icons/op3_publicaciones.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Publicaciones</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="Trivias.php" class="d-block">
                            <img src="images/icons/op4_trivias.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Trivias</strong></p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="cta-section section-padding section-bg">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">

                <div class="col-12">
                    <h2 class="mb-0">¿Sabes cuál es la huella hídrica que generas?</h2>
                </div>

            </div>
        </div>
    </section>

    <?php include 'mensaje_calculadora.php'; ?>

    <?php include 'apoyo.php'; ?>

</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
<script src="JS/jquery.sticky.js"></script>



<script src="JS/scriptCt.js"></script>
<!--<script src="JS/scriptCl.js"></script>-->

</body>

</html>