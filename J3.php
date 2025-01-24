<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include "./PHP/popups.php";
    include "./PHP/fov.php";
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J3Adm.php");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Para íconos -->

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <style>
        /* Estilos generales */
        .cuerpo {
            padding: 20px;
            background-color: #f9f9f9; /* Fondo claro para destacar */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
        }

        /*!* Botón Volver Atrás *!
        .btnBack {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 15px;
            color: #fff;
            background-color: #5bb5ab; !* Verde agua *!
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .btnBack:hover {
            background-color: #76c7c0; !* Más claro al pasar el cursor *!
            text-decoration: none;
        }*/

        /* Central (Texto y preguntas) */
        .central {
            text-align: center;
            margin-bottom: 30px;
        }

        .central h1, .central h2, .central h3 {
            color: #333; /* Texto oscuro */
            font-weight: bold;
            margin-bottom: 10px;
        }

        .central p.lectura {
            font-size: 1.1rem;
            color: #555; /* Gris suave */
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* Preguntas Falso o Verdadero */
        .rsFV {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 10px 0;
        }

        .rsFV label {
            font-size: 1.1rem;
            color: #333;
            font-weight: normal;
            cursor: pointer;
        }

        .rsFV input[type="radio"] {
            margin-right: 10px;
        }

        /* Botones y resultados */
        .vntOpr, .vntOpr2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .vntOpr a, .vntOpr2 button {
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            padding: 10px 20px;
            background-color: #5bb5ab;
            color: #fff;
            border-radius: 5px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .vntOpr a:hover, .vntOpr2 button:hover {
            background-color: #76c7c0;
        }

        /* Resultado */
        #resultadoFV {
            text-align: center;
            padding: 15px;
            background-color: #76c7c0; /* Fondo verde agua */
            color: #fff;
            border: 3px solid #5bb5ab; /* Borde */
            border-radius: 10px;
            max-width: 400px;
            margin: 20px auto 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>

</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="testimonial-section section-padding section-bg">
        <div class="container">
            <div class="row">
                <div class="cuerpo">
                    <!-- Botón Volver Atrás con imagen -->
                    <div class="d-flex align-items-center justify-content-end mb-3">
                        <a href="Trivias.php" class="btnBack d-flex align-items-center">
                            <i class="fas fa-arrow-circle-left me-2"></i>
                            Volver Atrás
                        </a>
                    </div>

                    <!-- Contenido Central -->
                    <div class="central">
                        <div id="actFVTxt">
                            <h1 class="text-center"><?php echo $titulo[0]; ?></h1>
                            <p class="lectura"><?php echo $afirmaciones[0]; ?></p>
                        </div>

                        <div class="actFV" id="actFV">
                            <div class="contTestFV">
                                <div id="testFV">
                                    <h5 class="text-center">Responde Falso o Verdadero</h5>
                                    <form id="formFV">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <div class="mb-4">
                                                <h7>Afirmación <?php echo $i; ?> (+2pts.)</h7>
                                                <p><?php echo $afirmaciones[$i]; ?></p>
                                                <div class="row g-2 mt-2 rsFV">
                                                    <div class="col-12 col-md-4">
                                                        <label class="d-flex align-items-start">
                                                            <input type="radio" name="a<?php echo $i; ?>" value="f" class="me-2">(F) Falso
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label class="d-flex align-items-start">
                                                            <input type="radio" name="a<?php echo $i; ?>" value="v" class="me-2">(V) Verdadero
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex flex-column align-items-center mt-4">
                        <div class="vntOpr" id="vOp1">
                            <a href="javascript:mostrarFV()" class="btnBack">
                                Continuar <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="vntOpr2" id="vOp2">
                            <button type="button" onclick="calcularPuntuacion()" class="btn btn-custom">Calcular Resultado</button>
                            <div id="resultadoFV" class="text-center mt-2 p-3" style="display: none;">
                                <h2 style="color: #ffffff; font-weight: bold;">Resultado</h2>
                                <p id="puntuacionFV" style="font-size: 1.25rem; color: #ffffff;"></p>
                            </div>
                            <a href="javascript:ocultarFV()" class="btnBack">
                                <i class="fas fa-arrow-circle-left"></i> Volver al Texto
                            </a>
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
<!--<script src="JS/click-scroll.js"></script>
<script src="JS/counter.js"></script>
<script src="JS/custom.js"></script>-->

<script src="JS/scriptJuego3.js"></script>

</body>

</html>