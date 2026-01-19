<?php 
    header('Content-Type: text/html; charset=utf-8');
    include "./PHP/conexionBe.php";
    include "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador','Usuario','Docente'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: NoticiasSl.php");
        session_destroy();
        die();
    } /*else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: TriviasAdm.php");
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

    <!-- Trivias -->
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/CSS/styleTr.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">-->

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Para íconos -->


    <style>
        .custom-badge {
            width: 1.8rem;       /* Tamaño del ancho */
            height: 1.8rem;      /* Tamaño del alto */
            display: flex;     /* Centrar contenido */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center;     /* Centrar verticalmente */
            font-size: 1rem; /* Tamaño del texto */
            font-weight: bold; /* Texto en negrita */
            background-color: #24a883; /* Color de fondo (Bootstrap primary) */
            color: #fff;       /* Color del texto */
            border-radius: 0.25rem; /* Esquinas ligeramente redondeadas */
        }

        .avatar-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        /* Asegurar que todos los bloques tengan la misma altura */
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Forzar que el contenido textual ocupe el espacio necesario y empuje el botón */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        /* Espaciado uniforme para el texto */
        .card-text {
            margin-bottom: auto; /* Empuja el texto hacia arriba */
        }

        /* Estilo del botón con ícono */
        .btn-with-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .img-custom-size {
            width: 80%; /* Ajusta este valor según el tamaño deseado */
            max-width: 300px; /* Limita el tamaño máximo */
            height: auto; /* Mantiene la proporción de la imagen */
        }
    </style>

</head>

<body id="section_1">

<?php include 'header_info.php'; ?>

<?php include 'modal_cierre.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-12 mx-auto">

                    <section class="py-5">
                        <div class="container">
                            <div class="row g-4">
                                <!-- Bloques -->
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/notebook.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 1">
                                        <div class="card-body text-center">
                                            <p class="card-text">Prueba tu conocimiento y gana puntos con este sencillo test.</p>
                                            <a href="J2.php" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/037-tierra.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 2">
                                        <div class="card-body text-center">
                                            <p class="card-text">Encuentra los pares y obten puntos!!!</p>
                                            <a href="J1.php" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/001-avion-de-papel.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 3">
                                        <div class="card-body text-center">
                                            <p class="card-text">Aprende algo nuevo, rinde un pequeño test y gana puntos.</p>
                                            <a href="J3.php" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/002-estera.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 4">
                                        <div class="card-body text-center">
                                            <p class="card-text">¿Podrás adivinar la palabra correcta?</p>
                                            <a href="J4.php" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/005-libro.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 5">
                                        <div class="card-body text-center">
                                            <p class="card-text">Ordena, elige sabiamente y gana!!!</p>
                                            <a href="J5.php" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img src="IMG/008-prueba.png" class="card-img-top img-custom-size mx-auto d-block" alt="Imagen 6">
                                        <div class="card-body text-center">
                                            <p class="card-text">¡Intenta encontrar todas las palabras!</p>
                                            <a href="SopaLetras/index.html" class="btn btn-primary btn-with-icon">
                                                <i class="fas fa-arrow-right"></i> Ir ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

                <div class="col-lg-4 col-12 mx-auto mt-4 mt-lg-0">

                    <div class="contact-info-wrap">
                        <h5 class="mb-3">Ranking</h5>
                        <div class="table-responsive">
                            <span id="rankingTable"></span>
                        </div>
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

<script src="JS/scriptLog.js"></script>

<!-- Trivias -->
<!--<script src="JS/scriptCt.js"></script>
<script src="JS/scriptTr.js"></script>-->
<script src="JS/rank.js"></script>

</body>

</html>