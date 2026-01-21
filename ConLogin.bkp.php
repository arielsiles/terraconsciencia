<?php
header('Content-Type: text/html; charset=utf-8');
require "./PHP/popups.php";
require "./PHP/direcciones.php";
session_start();
$roles_permitidos = ['Administrador','Usuario'];
if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
    header("Location: SinLogin.php");
    session_destroy();
    die();
} else {
    if ($_SESSION['rol'] == 'Administrador') {
        header("Location: ConLoginAdm.php");
    }
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

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">
    <!--

TemplateMo 581 Kind Heart Charity

https://templatemo.com/tm-581-kind-heart-charity

-->

</head>

<body id="section_1">

<header class="site-header">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-12 d-flex flex-wrap">
                <p class="d-flex me-4 mb-0">
                    <i class="bi-geo-alt me-2"></i>
                    Cochabamba, Bolivia
                </p>

                <p class="d-flex mb-0">
                    <i class="bi-envelope me-2"></i>

                    <a href="mailto:gaiapacha@gaiapacha.org">
                        gaiapacha@gaiapacha.org
                    </a>
                </p>
            </div>

            <div class="col-lg-3 col-12 ms-auto d-lg-block d-none">
                <ul class="social-icon">


                    <li class="social-icon-item">
                        <a href="https://www.facebook.com/gaiapacha" target="_blank" class="social-icon-link bi-facebook"></a>
                    </li>

                    <li class="social-icon-item">
                        <a href="https://www.instagram.com/gaiapacha" target="_blank" class="social-icon-link bi-instagram"></a>
                    </li>

                    <li class="social-icon-item">
                        <a href="https://www.linkedin.com/company/fundaci%C3%B3n-gaia-pacha" target="_blank" class="social-icon-link bi-linkedin"></a>
                    </li>

                    <li class="social-icon-item">
                        <a href="http://wa.me/59176957456" target="_blank" class="social-icon-link bi-whatsapp"></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header>

<!-- Modal de cierre de sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Cerrar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea cerrar sesión?</p>
            </div>
            <div class="modal-footer">
                <a class="custom-btn" href="PHP/cerrar_sesion.php">Sí</a>
                <button type="button" class="custom-btn" data-bs-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo-color-02.png" class="logo img-fluid" alt="Kind Heart Charity">
            <!--<span>Kind Heart Charity<small>Non-profit Organization</small></span>-->
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#top">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_2">Noticias</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_3">Publicaciones</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_4">Trivias</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                       id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">Cuenta</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="Cuenta.php?id=<?php echo $_SESSION['usuario'];?>">Ir a mi cuenta</a></li>

                        <li>
                            <!--<a class="dropdown-item" href="javascript:abreConf()">Cerrar sesión</a>-->
                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal"> <i class="fas fa-sign-out-alt"></i> <p>Cerrar Sesion</p> </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </div>
</nav>

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
                        <a href="donate.html" class="d-block">
                            <img src="images/icons/op1_calculadora.png" class="featured-block-image img-fluid" alt="">
                            <p class="featured-block-text"><strong>Calculadora Hídrica</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="donate.html" class="d-block">
                            <img src="images/icons/op2_noticias.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Noticias</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="donate.html" class="d-block">
                            <img src="images/icons/op3_publicaciones.png" class="featured-block-image img-fluid" alt="">

                            <p class="featured-block-text"><strong>Publicaciones</strong></p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="donate.html" class="d-block">
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
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-5 col-12 ms-auto">
                    <h2 class="mb-0">¿Sabes cuál es la huella hídrica que generas?</h2>
                </div>

                <div class="col-lg-5 col-12">
                    <a href="#" class="me-4">¡Descúbrelo ahora!</a>

                    <a href="#section_4" class="custom-btn btn smoothscroll">Haz click para empezar</a>
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

                        <!--<p class="text-muted mb-lg-4 mb-md-4">Founding Partner</p>-->

                        <!--<p>Lorem Ipsum dolor sit amet, consectetur adipsicing kengan omeg kohm tokito Professional
                            charity theme based</p>-->

                        <!--<p>Sed leo nisl, posuere at molestie ac, suscipit auctor mauris. Etiam quis metus</p>-->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 mb-4">
                <img src="images/logo-terra-b.png" class="logo-footer img-fluid" alt="">
            </div>

            <div class="col-lg-4 col-md-6 col-12 mx-auto">
                <h5 class="site-footer-title mb-3">FUNDACIÓN GAIA PACHA</h5>

                <p class="text-white d-flex mb-2">
                    <i class="bi-telephone me-2"></i>

                    <a href="tel: +591 76957456" class="site-footer-link">
                        +591 76957456
                    </a>
                </p>

                <p class="text-white d-flex">
                    <i class="bi-envelope me-2"></i>

                    <a href="mailto:gaiapacha@gaiapacha.org" class="site-footer-link">
                        gaiapacha@gaiapacha.org
                    </a>
                </p>

                <p class="text-white d-flex mt-3">
                    <i class="bi-geo-alt me-2"></i>
                    Calle Idelfonso Murguia 777, <br />entre Tocopilla y C. Antofagasta, <br />Cochabamba - Bolivia
                </p>

                <!--<a href="#" class="custom-btn btn mt-3">Get Direction</a>-->
            </div>

            <div class="col-lg-4 col-md-6 col-12 mx-auto">
                <h5 class="site-footer-title mb-3">SOLIDAGRO</h5>

                <p class="text-white d-flex mb-2">
                    <i class="bi-telephone me-2"></i>

                    <a href="tel: +32 3 777 20 15" class="site-footer-link">
                        +32 3 777 20 15
                    </a>
                </p>

                <p class="text-white d-flex">
                    <i class="bi-envelope me-2"></i>

                    <a href="mailto:info@solidagro.be" class="site-footer-link">
                        info@solidagro.be
                    </a>
                </p>
            </div>

        </div>
    </div>

    <div class="site-footer-bottom">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-7 col-12">
                    <p class="copyright-text mb-0">
                        Copyright © 2025
                        <a href="https://gaiapacha.org" target="_blank">Fundación Gaia Pacha</a>
                    </p>
                </div>

                <div class="col-lg-6 col-md-5 col-12 d-flex justify-content-center align-items-center mx-auto">
                    <ul class="social-icon">
                        <li class="social-icon-item">
                            <a href="https://www.facebook.com/gaiapacha" target="_blank" class="social-icon-link bi-facebook"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="https://www.instagram.com/gaiapacha" target="_blank" class="social-icon-link bi-instagram"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="https://www.linkedin.com/company/fundaci%C3%B3n-gaia-pacha" target="_blank" class="social-icon-link bi-linkedin"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="http://wa.me/59176957456" target="_blank" class="social-icon-link bi-whatsapp"></a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
</footer>

<!-- JAVASCRIPT FILES -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/click-scroll.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>


<script src="JS/scriptCt.js"></script>
<!--<script src="JS/scriptCl.js"></script>-->

</body>

</html>