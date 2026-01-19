<?php
    header('Content-Type: text/html; charset=utf-8');
    include "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador','Usuario','Docente'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } /*else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: PublicacionesAdm.php");
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

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px; /* Ajusta el ancho */
            height: 30px; /* Ajusta la altura */
            background-size: 100%; /* Ajusta la escala del icono */
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px; /* Ajusta el área clickeable del botón */
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

<?php include 'modal_cierre.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">
                <?php include 'publicaciones_s1.php'; ?>
            </div>
            <div class="row">
                <?php include 'publicaciones_s2.php'; ?>
            </div>
            <div class="row">
                <?php include 'publicaciones_s3.php'; ?>
            </div>

        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->

<!-- Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>