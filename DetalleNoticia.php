<?php
header('Content-Type: text/html; charset=utf-8');
include "./PHP/conexionBe.php";
if (isset($_GET['id'])) {
    $id_noticia = $_GET['id'];
    $query = "SELECT * FROM noticias WHERE id_noticia = $id_noticia";
    $result = mysqli_query($conexion, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $titulo_noticia = $row['titulo_noticia'];
        $imagen_noticia = $row['imagen_noticia'];
        $descripcion_noticia = $row['descripcion_noticia'];
        $noticia_completa = $row['noticia_completa'];

        $fecha = $row['creacion_noticia'];
        $timestamp = strtotime($fecha);
        $fecha_formato = strftime('%A, %d de %B de %Y', $timestamp);

    }
}
session_start();
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
    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

</head>

<body id="section_1">

<?php include 'header_info.php'; ?>

<?php include 'main_menu_single.php'; ?>

<main>

    <?php include 'header_section_news.php'; ?>

    <section class="news-section section-padding">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="news-block p-4 border rounded shadow">

                        <div class="news-block-info">
                            <div class="news-block-title mb-2">
                                <h4><?php echo $titulo_noticia; ?></h4>
                            </div>
                        </div>

                        <div class="news-block-body">
                            <p><?php echo $descripcion_noticia; ?></p>
                        </div>

                        <div class="news-block-top">
                            <img src="<?php $imagen_noticia = str_replace('../', './', $imagen_noticia); echo $imagen_noticia; ?>"
                                 class="news-image img-fluid mb-3" alt="">
                            <div class="news-category-block">
                                <a href="NoticiasSl.php" class="category-block-link">
                                    << Atras
                                </a>
                            </div>
                        </div>

                        <div class="news-block-info">
                            <div class="d-flex mt-2">
                                <div class="news-block-date me-3">
                                    <p><i class="bi-calendar4 custom-icon me-1"></i><?php echo $fecha_formato; ?></p>
                                </div>
                                <div class="news-block-author">
                                    <p><i class="bi-person custom-icon me-1"></i>Por GaiaPacha</p>
                                </div>
                            </div>

                            <div class="news-block-body mt-3">
                                <p><?php echo $noticia_completa; ?></p>

                                <p>
                                    <a href="NoticiasSl.php" class="category-block-link">
                                        << Atras
                                    </a>
                                </p>

                            </div>
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

</body>

</html>