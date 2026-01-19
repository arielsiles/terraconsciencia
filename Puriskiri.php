<?php
session_start();
$roles_permitidos = ['Administrador', 'Docente', 'Usuario'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: SinLogin.php");
    session_destroy();
    die();
}

include "PHP/conexionBe.php";

// Obtener categorías con conteo de recursos
$query_categorias = "SELECT c.*,
    (SELECT COUNT(*) FROM puriskiri_recursos r WHERE r.categoria_id = c.id AND r.activo = 1) as total_recursos
    FROM puriskiri_categorias c
    WHERE c.activo = 1
    ORDER BY c.orden";
$resultado_categorias = mysqli_query($conexion, $query_categorias);

// Obtener recursos destacados
$query_destacados = "SELECT r.*, c.nombre as categoria_nombre, n.nombre as nivel_nombre
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE r.destacado = 1 AND r.activo = 1
    ORDER BY r.descargas DESC
    LIMIT 3";
$resultado_destacados = mysqli_query($conexion, $query_destacados);

// Imágenes por defecto para categorías
$imagenes_categoria = [
    'agua' => 'images/causes/group-people-volunteering-foodbank-poor-people.jpg',
    'ambiente' => 'images/causes/poor-child-landfill-looks-forward-with-hope.jpg',
    'agricultura' => 'images/causes/medium-shot-people-collecting-donations.jpg',
    'alimentacion' => 'images/causes/teaching-lesson-different-religions.jpg',
    'clima' => 'images/causes/poverty-and-inequality-concept-with-full-shot-of-sad-man.jpg',
    'biodiversidad' => 'images/causes/children-coming-back-from-school.jpg'
];

// Colores de badges por categoría
$colores_categoria = [
    'agua' => 'primary',
    'ambiente' => 'success',
    'agricultura' => 'warning',
    'alimentacion' => 'info',
    'clima' => 'danger',
    'biodiversidad' => 'secondary'
];

// Función para obtener icono de tipo de archivo
function getIconoTipo($tipo) {
    $iconos = [
        'pdf' => 'fa-file-pdf',
        'ppt' => 'fa-file-powerpoint',
        'pptx' => 'fa-file-powerpoint',
        'doc' => 'fa-file-word',
        'docx' => 'fa-file-word',
        'xlsx' => 'fa-file-excel'
    ];
    return isset($iconos[$tipo]) ? $iconos[$tipo] : 'fa-file';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="PURISKIRI - Centro de Recursos Educativos">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>PURISKIRI - Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!-- CSS Especifico PURISKIRI -->
    <link href="assets/CSS/stylePuriskiri.css" rel="stylesheet">

    <!-- Font Awesome para iconos adicionales -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body id="section_1">

<?php include "header_info.php"; ?>
<?php include "main_menu_user.php"; ?>

<main>
    <!-- HERO SECTION -->
    <section class="cta-section section-padding section-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12 text-center mx-auto">
                    <h1 class="mb-3">PURISKIRI</h1>
                    <h4 class="mb-3">Centro de Recursos Educativos</h4>
                    <p class="lead">Un espacio dedicado para compartir conocimiento y construir juntos una educacion transformadora</p>
                </div>
            </div>

            <!-- BOTONES PRINCIPALES -->
            <div class="row mt-5">
                <!-- BOTON DESCARGAR -->
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="PuriskiriDescargar.php" class="d-block text-center">
                            <i class="fas fa-download fa-4x mb-3" style="color: #5bc1ac;"></i>
                            <p class="featured-block-text"><strong>Descargar Recursos</strong></p>
                            <p class="text-muted">Accede a materiales educativos actualizados</p>
                        </a>
                    </div>
                </div>

                <!-- BOTON SUBIR (solo para Docente y Admin) -->
                <?php if (in_array($_SESSION['rol'], ['Administrador', 'Docente'])) { ?>
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <a href="PuriskiriSubir.php" class="d-block text-center">
                            <i class="fas fa-upload fa-4x mb-3" style="color: #FF6600;"></i>
                            <p class="featured-block-text"><strong>Subir Recursos</strong></p>
                            <p class="text-muted">Comparte tus materiales con la comunidad</p>
                        </a>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="featured-block d-flex justify-content-center align-items-center">
                        <div class="d-block text-center">
                            <i class="fas fa-book-open fa-4x mb-3" style="color: #FF6600;"></i>
                            <p class="featured-block-text"><strong>Explora el Catalogo</strong></p>
                            <p class="text-muted">Encuentra materiales para tus clases</p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- BARRA DE BUSQUEDA -->
    <section class="section-padding search-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <form action="PuriskiriDescargar.php" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Buscar recursos por tema, nivel o palabra clave..." name="buscar">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIAS TEMATICAS -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>Explora por Categoria</h3>
                    <p class="text-muted">Encuentra recursos organizados por temas educativos</p>
                </div>
            </div>

            <div class="row g-4">
                <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
                    $imagen = isset($imagenes_categoria[$categoria['slug']]) ? $imagenes_categoria[$categoria['slug']] : 'images/causes/group-people-volunteering-foodbank-poor-people.jpg';
                    $color = isset($colores_categoria[$categoria['slug']]) ? $colores_categoria[$categoria['slug']] : 'primary';
                ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="resource-card" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?php echo $imagen; ?>');">
                        <a href="PuriskiriDescargar.php?categoria=<?php echo $categoria['slug']; ?>" class="download-btn-category">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <div class="resource-card-body">
                            <h5 class="resource-card-title"><?php echo htmlspecialchars($categoria['nombre']); ?></h5>
                            <p class="resource-card-text"><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
                            <span class="badge bg-<?php echo $color; ?>"><?php echo $categoria['total_recursos']; ?> recursos</span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- RECURSOS DESTACADOS -->
    <section class="section-padding section-bg">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>Recursos Destacados</h3>
                    <p class="text-muted">Los materiales mas descargados y mejor valorados</p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                if (mysqli_num_rows($resultado_destacados) > 0) {
                    while ($recurso = mysqli_fetch_assoc($resultado_destacados)) {
                        $portada = !empty($recurso['ruta_portada']) ? $recurso['ruta_portada'] : 'images/causes/group-people-volunteering-foodbank-poor-people.jpg';
                ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="resource-card-download">
                        <div class="resource-card-image" style="background-image: url('<?php echo htmlspecialchars($portada); ?>');">
                            <a href="PHP/puriskiri_descargar.php?id=<?php echo $recurso['id']; ?>" class="download-btn-corner">
                                <i class="fas fa-download"></i>
                            </a>
                            <span class="badge-file-type">
                                <i class="fas <?php echo getIconoTipo($recurso['tipo_archivo']); ?>"></i> <?php echo strtoupper($recurso['tipo_archivo']); ?>
                            </span>
                        </div>

                        <div class="resource-card-info">
                            <h6 class="resource-title">
                                <a href="PuriskiriDetalle.php?id=<?php echo $recurso['id']; ?>"><?php echo htmlspecialchars($recurso['titulo']); ?></a>
                            </h6>
                            <p class="resource-meta text-muted small">
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($recurso['categoria_nombre']); ?><br>
                                <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($recurso['nivel_nombre']); ?><br>
                                <i class="fas fa-download"></i> <?php echo $recurso['descargas']; ?> descargas
                            </p>
                            <p class="resource-description">
                                <?php echo htmlspecialchars(substr($recurso['descripcion'], 0, 150)) . '...'; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No hay recursos destacados aun. Se el primero en compartir materiales educativos.</p>
                </div>
                <?php } ?>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="PuriskiriDescargar.php" class="btn btn-primary btn-lg">
                        Ver Todos los Recursos
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include "footer.php"; ?>
<?php include "modal_cierre.php"; ?>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>

</body>

</html>
