<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require "./PHP/preguntasTest.php";
    include "./PHP/popups.php";
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } /*else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J2Adm.php");
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

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Para íconos -->

    <!-- Origin -->
    <link rel="stylesheet" href="assets/CSS/style-buttons.css">


</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="testimonial-section section-padding section-bg">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="cuerpo">
                        <!-- Botón Volver Atrás con imagen -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="Trivias.php" class="btnBack d-flex align-items-center">
                                <i class="fas fa-arrow-circle-left me-2"></i>
                                Volver Atrás
                            </a>
                            <img src="IMG/estres.png" alt="Pregunta" style="width: 100px; height: auto;">
                        </div>


                        <!-- Contenido del test -->
                        <div id="test">
                            <h1 class="text-center">Test de Conocimientos</h1>
                            <form id="formulario">
                                <?php
                                for ($i = 0; $i < 10; $i++) {
                                    echo "
                                            <div class='mb-4'>
                                                <h5>Pregunta " . ($i + 1) . "</h5>
                                                <h3>{$pregunta[$i]}</h3>
                                                <div class='row g-2 mt-2'>
                                                    <div class='col-12 col-md-4'>
                                                        <label class='d-flex align-items-start'>
                                                            <input type='radio' name='p" . ($i + 1) . "' value='a' class='me-2'>
                                                            {$opc1[$i]}
                                                        </label>
                                                    </div>
                                                    <div class='col-12 col-md-4'>
                                                        <label class='d-flex align-items-start'>
                                                            <input type='radio' name='p" . ($i + 1) . "' value='b' class='me-2'>
                                                            {$opc2[$i]}
                                                        </label>
                                                    </div>
                                                    <div class='col-12 col-md-4'>
                                                        <label class='d-flex align-items-start'>
                                                            <input type='radio' name='p" . ($i + 1) . "' value='c' class='me-2'>
                                                            {$opc3[$i]}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            ";
                                }
                                ?>
                            </form>
                        </div>


                        <!-- Botón Calcular Resultado con imagen -->
                        <div class="d-flex flex-column align-items-center mt-4">
                            <img src="IMG/pregunta.png" alt="Pregunta" style="width: 100px; height: auto; margin-bottom: 10px;">
                            <button type="button" onclick="calcularResultado()" class="btn btn-custom">
                                Calcular Resultado
                            </button>
                        </div>


                        <!-- Resultado -->
                        <div id="resultado" class="text-center mt-2 p-3"
                             style="display: none;
                            background-color: #76c7c0; /* Fondo uniforme */
                            border: 3px solid #5bb5ab; /* Borde */
                            border-radius: 10px; /* Esquinas redondeadas */
                            max-width: 500px; /* Ancho máximo */
                            margin: 0 auto; /* Centrado horizontal */
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

                            <h2 style="color: #ffffff; font-weight: bold;">Resultado</h2>
                            <p id="puntuacion" style="font-size: 1.25rem; color: #ffffff;"></p>
                        </div>

                    </div>
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
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>

<script src="JS/scriptLog.js"></script>

<!-- Trivias -->
<script src="JS/scriptCt.js"></script>
<script src="JS/scriptTr.js"></script>
<script src="JS/rank.js"></script>

<script src="PHP/calcularResultado.php"></script>

</body>

</html>