<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include "./PHP/popups.php";
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J5Adm.php");
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!--<link rel="stylesheet" href="assets/CSS/styleJgs.css">-->

    <style>
        /*Juego 5*/
        .button {
            padding: 1rem 2rem;
            border-radius: .5rem;
            border: none;
            font-size: 1rem;
            font-weight: 400;
            color: #f4f0ff;
            text-align: center;
            backdrop-filter: blur(10px);
            cursor: pointer;
            position: relative;
        }

        .button::before {
            content: "";
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            border-radius: .5rem;
            background: linear-gradient(180deg, rgba(8, 77, 126, 0) 0%, rgba(8, 77, 126, 0.42) 100%), rgba(47,255,255,.24);
            box-shadow: inset 0 0 12px rgba(151,200,255,.44);
            z-index: -1;
        }

        .button::after {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(8, 77, 126, 0) 0%, rgba(8, 77, 126, 0.42) 100%), rgba(47,255,255,.24);
            box-shadow: inset 0 0 12px rgba(151,200,255,.44);
            border-radius: .5rem;
            opacity: 0;
            z-index: -1;
            transition: all .3s ease-in;
        }

        .button:hover::after {
            opacity: 1;
        }

        .button-border {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: .5rem;
            z-index: -1;
        }

        .button-border::before {
            content: "";
            position: absolute;
            border-radius: .5rem;
            padding: 1px;
            inset: 0;
            background: linear-gradient(180deg, rgba(184, 238, 255, 0.24) 0%, rgba(184, 238, 255, 0) 100%), linear-gradient(0deg, rgba(184, 238, 255, 0.32), rgba(184, 238, 255, 0.32));
            pointer-events: none;
        }

        #evaluarButton {
            background-color: #799f9f;
            color: white;
            margin: 0 auto;
            display: block;
            max-width: 200px;
        }

        #Puntuacion {
            font-size: 2rem;
            margin-top: 5px;
            text-align: center;
        }

        #juego {
            width: 100%;
            height: auto;
            min-height: 650px;
            /*background-color: #7EB9C0;*/
            padding: 10px;
            box-sizing: border-box;
        }

        /* Media Queries para responsividad */
        @media (max-width: 1200px) {
            #evaluarButton {
                margin-left: auto;
                margin-right: auto;
            }

            #Puntuacion {
                font-size: 2rem;
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (max-width: 768px) {
            .button {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }

            #Puntuacion {
                font-size: 1.5rem;
            }

            #evaluarButton {
                max-width: 180px;
            }

            #juego {
                padding: 5px;
            }
        }

        @media (max-width: 480px) {
            .button {
                padding: 0.6rem 1.2rem;
                font-size: 0.8rem;
            }

            #Puntuacion {
                font-size: 1.2rem;
            }

            #evaluarButton {
                max-width: 160px;
            }

            #juego {
                padding: 3px;
            }
        }
    </style>


</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <!--<section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div id="juego">
                    <h3>Selecciona las imagenes correctamente segun su contenedor.</h3>
                    <script src="JS/game.js"></script>
                </div>

            </div>
        </div>
    </section>-->

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">
                <div id="juego">
                    <h3>Selecciona las imagenes correctamente según su contenedor.</h3>
                    <script src="JS/game.js"></script>
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

<!--<script src="JS/game.js"></script>-->

</body>

</html>