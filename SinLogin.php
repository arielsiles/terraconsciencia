<?php
    header('Content-Type: text/html; charset=utf-8');
    require "./PHP/popups.php";
    require './PHP/direcciones.php';
    session_start();
    $config = include('./PHP/config.php');

    if(isset($_SESSION['usuario'])){
        header("location: ConLogin.php");
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
    <!--<link rel="stylesheet" href="assets/CSS/styleSl.css">-->

    <!-- CSS FILES TemplateMo 581 Kind Heart Charity -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

</head>

<body id="section_1">

<?php include 'header_info.php'; ?>

<?php include 'modal_iniciar.php'; ?>
<?php include 'modal_registro.php'; ?>



<!-- Menu -->
<?php include 'main_menu.php'; ?>

<main>

    <?php include 'header_section.php'; ?>

    <section class="section-padding-home">
        <div class="container">
            <div class="row justify-content-center align-items-center">

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
                        <a href="NoticiasSl.php" class="d-block">
                            <img src="images/icons/op2_noticias.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Noticias</strong></p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="cta-section section-padding section-bg">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-5 col-12 ms-auto">
                    <h2 class="mb-0">¿Sabes cuál es la huella hídrica que generas?</h2>
                </div>

                <div class="col-lg-5 col-12">
                    <a href="#" class="me-4">¡Descúbrelo ahora!</a>

                    <a href="CalculadoraInicio.html" class="custom-btn btn smoothscroll">Haz click para empezar</a>
                </div>

            </div>
        </div>
    </section>

    <section class="about-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-5 col-12">
                    <img src="IMG/Ilustracionessolopersonaje-05.svg"
                         class="about-image ms-lg-auto bg-light shadow-lg img-fluid" alt="">
                </div>

                <div class="col-lg-5 col-md-7 col-12">
                    <div class="custom-text-block">
                        <h2 class="mb-0">Desde ahora empieza el cambio desde tu conocimiento a la acción <br />¡Prepárate!</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->

<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
<script src="JS/jquery.sticky.js"></script>
<script src="JS/click-scroll.js"></script>
<script src="JS/counter.js"></script>
<script src="JS/custom.js"></script>

<script src="JS/scriptLog.js"></script>
</body>

</html>