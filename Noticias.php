<?php 
    header('Content-Type: text/html; charset=utf-8');
    include "./PHP/conexionBe.php";
    include "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: NoticiasSl.php");
        session_destroy();
        die();
    } /*else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: NoticiasAdm.php");
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

<?php include 'main_menu_user.php'; ?>

<main>

    <?php include 'header_section_news.php'; ?>

    <section class="news-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-12 mx-auto">
                    <!--<div class="col-lg-7 col-12">-->


                    <?php
                    include "PHP/conexionBe.php";
                    //$query = "SELECT * FROM noticias WHERE noticia_destacada = 1";
                    $query = "SELECT * FROM noticias ORDER BY id_noticia DESC";
                    $result = $conexion->query($query);
                    ?>

                    <?php
                    while ($row = $result->fetch_assoc()){
                        $rutaImagen = str_replace('../', './', $row['imagen_noticia']);
                        $titulo = $row['titulo_noticia'];
                        $descripcion = $row['descripcion_noticia'];
                        $link = "DetalleNoticia.php?id=" . $row["id_noticia"];

                        $fecha = $row['creacion_noticia'];
                        $timestamp = strtotime($fecha);
                        $fecha_formateada = strftime('%A, %d de %B de %Y', $timestamp);

                        echo
                            '<div class="news-block mb-3">
                            <div class="news-block-top">
                                <img src="'.$rutaImagen.'" class="news-image img-fluid" alt="">

                                <div class="news-category-block">
                                    <a href="'.$link.'" class="category-block-link">Leer mas...</a>
                                </div>
                            </div>

                            <div class="news-block-info">
                                <div class="d-flex mt-2">
                                    <div class="news-block-date">
                                        <p><i class="bi-calendar4 custom-icon me-1"></i>'.$fecha_formateada.'</p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p><i class="bi-person custom-icon me-1"></i>Por GaiaPacha</p>
                                    </div>

                                </div>

                                <div class="news-block-title mb-2">
                                    <h4><a href="'.$link.'" class="news-block-title-link">'.$titulo.'</a></h4>
                                </div>

                                <div class="news-block-body">
                                    <p>'.$descripcion.'</p>
                                </div>
                            </div>
                        </div>';
                    } ?>

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
<!--<script src="js/click-scroll.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>-->

<script src="JS/scriptCt.js"></script>
<!--<script src="JS/scriptLog.js"></script>-->
</body>

</html>