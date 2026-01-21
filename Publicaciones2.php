<?php
    header('Content-Type: text/html; charset=utf-8');
    include "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J1Adm.php");
        }
    }
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
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- Agregar Font Awesome para usar los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Version ok B5-->
    <!--<style>
        .card {
            position: relative;
            width: 23%; /* Ocupa el 23% del ancho del contenedor para que quepan 4 cards con espacio */
            height: 300px; /* Altura fija para mantener un diseño uniforme */
            border-radius: 15px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            margin: 0 10px; /* Espaciado horizontal */
        }

        .cards-wrapper {
            display: flex;
            justify-content: space-between; /* Distribuye uniformemente los cards */
            gap: 10px; /* Espaciado entre cards */
        }

        .card-body {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo claro con transparencia */
            color: black; /* Texto negro */
            padding: 10px;
            box-sizing: border-box;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.4;
            margin: 0;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Máximo de 4 líneas */
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            z-index: 2;
        }

        .download-btn:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }
    </style>-->

    <style>
        .card {
            position: relative;
            height: 300px; /* Altura fija para los cards */
            border-radius: 15px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }

        .card-body {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo claro con transparencia */
            color: black; /* Texto negro */
            padding: 10px;
            box-sizing: border-box;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.4;
            margin: 0;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Máximo de 4 líneas */
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            z-index: 2;
        }

        .download-btn:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* Estilos responsivos */
        @media (min-width: 992px) {
            /* Pantallas grandes: 4 cards */
            .carousel-item .col {
                flex: 0 0 25%; /* Cada card ocupa el 25% del ancho */
                max-width: 25%;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            /* Pantallas medianas: 2 cards */
            .carousel-item .col {
                flex: 0 0 50%; /* Cada card ocupa el 50% del ancho */
                max-width: 50%;
            }
        }

        @media (max-width: 767.98px) {
            /* Pantallas pequeñas: 1 card */
            .carousel-item .col {
                flex: 0 0 100%; /* Cada card ocupa el 100% del ancho */
                max-width: 100%;
            }
        }
    </style>

</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>
    <!-- Version ok B5 -->
    <!--<section class="news-section section-padding">
        <div class="container">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <div class="cards-wrapper">
                            <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text">Cartilla orientada a jóvenes para aprender la importancia del agua en el planeta. Resalta la relación del recurso con la agricultura, así como con las acciones de consumo y protección.</p>
                                </div>
                            </div>
                            <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/Reglas-basicas-para-cultivar.png');">
                                <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text">Guía básica para iniciar un huerto orgánico y saludable a través de la siembra de semillas y plantines, presentado en forma sencilla y educativa.</p>
                                </div>
                            </div>
                            <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text">Cartilla orientada a jóvenes sobre el uso de recursos hídricos...</p>
                                </div>
                            </div>
                            <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text">Tríptico sobre recursos sostenibles y salud...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="cards-wrapper">
                            <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text">Otro recurso educativo para jóvenes...</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>-->

    <section class="news-section section-padding">
        <div class="container">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Página 1 -->
                    <div class="carousel-item active">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                    <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">Cartilla orientada a jóvenes para aprender la importancia del agua en el planeta...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                    <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">Tríptico sobre alimentos alimentarios para velar por el cuidado del medio ambiente...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                    <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">Cartilla orientada a jóvenes sobre el uso de recursos hídricos...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                    <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">Tríptico sobre recursos sostenibles y salud...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Página 2 -->
                    <div class="carousel-item">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="card" style="background-image: url('https://terraconsciencia.com/IMGUP/El_agua_es_vida_El_agua_nutre.png');">
                                    <a href="path-to-your-pdf.pdf" class="download-btn" download title="Descargar PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">Otro recurso educativo para jóvenes...</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Otros 3 cards aquí -->
                        </div>
                    </div>
                </div>

                <!-- Controles del carrusel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->

<!-- Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>