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
            header("Location: J1Adm.php");
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/styleJ1.css">


</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <!--<section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div class="cuerpo">
                    <div class="lado">
                        <a href="Trivias.php" class="btnBack">
                            <i class="fas fa-arrow-circle-left"></i>
                            Volver Atras
                        </a>
                    </div>
                    <div id="juego-memoria">
                        <?php
/*                        include "./PHP/conexionBe.php";
                        $consulta = "SELECT * FROM orden_cartas ORDER BY orden";
                        $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['id'];
                            $orden = $fila['orden'];
                            $rutaImagen = str_replace('../', './', $fila['rutaImagen']);
                            echo "<div class='carta' onclick='voltearCarta(event)' style='order: $orden;'>";
                            echo "<div class='front'></div>";
                            echo "<div class='back'>";
                            echo "<img src='$rutaImagen' alt='Imagen'>";
                            echo "</div>";
                            echo "</div>";
                        }
                        mysqli_close($conexion);
                        */?>
                    </div>
                    <div class="lado"></div>
                </div>

            </div>
        </div>
    </section>-->

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">
                <div class="cuerpo">
                    <div id="juego-memoria" class="d-flex flex-wrap justify-content-center">
                        <?php
                        include "./PHP/conexionBe.php";
                        $consulta = "SELECT * FROM orden_cartas ORDER BY orden";
                        $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['id'];
                            $orden = $fila['orden'];
                            $rutaImagen = str_replace('../', './', $fila['rutaImagen']);
                            echo "<div class='carta' onclick='voltearCarta(event)' style='order: $orden;'>";
                            echo "<div class='front'></div>";
                            echo "<div class='back'>";
                            echo "<img src='$rutaImagen' alt='Imagen'>";
                            echo "</div>";
                            echo "</div>";
                        }
                        mysqli_close($conexion);
                        ?>
                    </div>

                    <div class="lado mt-3">
                            <a href="Trivias.php" class="btnBack">
                                <i class="fas fa-arrow-left"></i> Volver Atrás
                            </a>
                        </a>
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

<script src="JS/scriptCt.js"></script>
<script src="JS/scriptCl.js"></script>
<script src="JS/scripJgs.js"></script>

</body>

</html>