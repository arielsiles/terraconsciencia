<?php
session_start();
$roles_permitidos = ['Administrador', 'Docente', 'Usuario'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: SinLogin.php");
    session_destroy();
    die();
}

include "PHP/conexionBe.php";

// Obtener parámetros de filtro
$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';
$categoria_filtro = isset($_GET['categoria']) ? mysqli_real_escape_string($conexion, $_GET['categoria']) : '';
$nivel_filtro = isset($_GET['nivel']) ? mysqli_real_escape_string($conexion, $_GET['nivel']) : '';
$tipo_filtro = isset($_GET['tipo']) ? mysqli_real_escape_string($conexion, $_GET['tipo']) : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'recientes';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 12;
$offset = ($pagina - 1) * $por_pagina;

// Construir consulta
$where = "r.activo = 1";
$params = [];

if (!empty($buscar)) {
    $where .= " AND (r.titulo LIKE '%$buscar%' OR r.descripcion LIKE '%$buscar%' OR r.palabras_clave LIKE '%$buscar%')";
}
if (!empty($categoria_filtro)) {
    $where .= " AND c.slug = '$categoria_filtro'";
}
if (!empty($nivel_filtro)) {
    $where .= " AND n.slug = '$nivel_filtro'";
}
if (!empty($tipo_filtro)) {
    $where .= " AND r.tipo_archivo = '$tipo_filtro'";
}

// Ordenamiento
switch ($orden) {
    case 'descargas':
        $order_by = "r.descargas DESC";
        break;
    case 'az':
        $order_by = "r.titulo ASC";
        break;
    case 'za':
        $order_by = "r.titulo DESC";
        break;
    default:
        $order_by = "r.fecha_creacion DESC";
}

// Consulta principal
$query = "SELECT r.*, c.nombre as categoria_nombre, c.slug as categoria_slug, n.nombre as nivel_nombre
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE $where
    ORDER BY $order_by
    LIMIT $offset, $por_pagina";
$resultado = mysqli_query($conexion, $query);

// Contar total para paginación
$query_count = "SELECT COUNT(*) as total FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE $where";
$resultado_count = mysqli_query($conexion, $query_count);
$total = mysqli_fetch_assoc($resultado_count)['total'];
$total_paginas = ceil($total / $por_pagina);

// Obtener categorías para filtros
$query_categorias = "SELECT * FROM puriskiri_categorias WHERE activo = 1 ORDER BY orden";
$categorias = mysqli_query($conexion, $query_categorias);

// Obtener niveles para filtros
$query_niveles = "SELECT * FROM puriskiri_niveles ORDER BY orden";
$niveles = mysqli_query($conexion, $query_niveles);

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

// Construir URL base para paginación
function buildUrl($params) {
    $base = 'PuriskiriDescargar.php';
    if (!empty($params)) {
        $base .= '?' . http_build_query($params);
    }
    return $base;
}

$url_params = [];
if (!empty($buscar)) $url_params['buscar'] = $buscar;
if (!empty($categoria_filtro)) $url_params['categoria'] = $categoria_filtro;
if (!empty($nivel_filtro)) $url_params['nivel'] = $nivel_filtro;
if (!empty($tipo_filtro)) $url_params['tipo'] = $tipo_filtro;
if ($orden != 'recientes') $url_params['orden'] = $orden;
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Catalogo de Recursos Educativos - PURISKIRI">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Descargar Recursos - PURISKIRI</title>

    <link rel="shortcut icon" href="IMG/Icono.ico">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!-- CSS Especifico PURISKIRI -->
    <link href="assets/CSS/stylePuriskiri.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body id="section_1">

<?php include "header_info.php"; ?>
<?php include "main_menu_user.php"; ?>

<main>
    <!-- BREADCRUMB -->
    <section class="section-padding-top" style="padding-top: 30px;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Puriskiri.php">PURISKIRI</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Descargar Recursos</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- HEADER CON BUSQUEDA -->
    <section class="section-padding" style="padding-top: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>Catalogo de Recursos Educativos</h2>
                    <p class="text-muted">Explora y descarga materiales para tus clases</p>
                </div>

                <!-- Barra de busqueda -->
                <div class="col-lg-8 col-12 mx-auto mb-4">
                    <form action="PuriskiriDescargar.php" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar recursos..." name="buscar" value="<?php echo htmlspecialchars($buscar); ?>">
                            <?php if (!empty($categoria_filtro)) { ?>
                            <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria_filtro); ?>">
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENIDO CON SIDEBAR -->
    <section class="pb-5">
        <div class="container">
            <div class="row">
                <!-- SIDEBAR IZQUIERDO: FILTROS -->
                <div class="col-lg-3 col-12 mb-4">
                    <div class="custom-text-box">
                        <h5 class="mb-3"><i class="fas fa-filter"></i> Filtros</h5>

                        <form action="PuriskiriDescargar.php" method="get" id="filterForm">
                            <?php if (!empty($buscar)) { ?>
                            <input type="hidden" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>">
                            <?php } ?>

                            <!-- Filtro por Tema -->
                            <div class="mb-4">
                                <h6>Tema</h6>
                                <?php mysqli_data_seek($categorias, 0); ?>
                                <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="categoria" value="<?php echo $cat['slug']; ?>" id="cat_<?php echo $cat['slug']; ?>" <?php echo ($categoria_filtro == $cat['slug']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cat_<?php echo $cat['slug']; ?>">
                                        <?php echo htmlspecialchars($cat['nombre']); ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>

                            <!-- Filtro por Nivel -->
                            <div class="mb-4">
                                <h6>Nivel Educativo</h6>
                                <?php mysqli_data_seek($niveles, 0); ?>
                                <?php while ($niv = mysqli_fetch_assoc($niveles)) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nivel" value="<?php echo $niv['slug']; ?>" id="niv_<?php echo $niv['slug']; ?>" <?php echo ($nivel_filtro == $niv['slug']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="niv_<?php echo $niv['slug']; ?>">
                                        <?php echo htmlspecialchars($niv['nombre']); ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>

                            <!-- Filtro por Tipo -->
                            <div class="mb-4">
                                <h6>Tipo de Material</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo" value="pdf" id="tipo_pdf" <?php echo ($tipo_filtro == 'pdf') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="tipo_pdf">
                                        <i class="fas fa-file-pdf text-danger"></i> PDF
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo" value="ppt" id="tipo_ppt" <?php echo ($tipo_filtro == 'ppt' || $tipo_filtro == 'pptx') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="tipo_ppt">
                                        <i class="fas fa-file-powerpoint text-warning"></i> PowerPoint
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo" value="doc" id="tipo_doc" <?php echo ($tipo_filtro == 'doc' || $tipo_filtro == 'docx') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="tipo_doc">
                                        <i class="fas fa-file-word text-primary"></i> Word
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                            <a href="PuriskiriDescargar.php" class="btn btn-outline-secondary w-100 mt-2">Limpiar</a>
                        </form>
                    </div>
                </div>

                <!-- CONTENIDO PRINCIPAL: GRID DE RECURSOS -->
                <div class="col-lg-9 col-12">
                    <!-- Resultados y ordenamiento -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                        <p class="text-muted mb-2 mb-md-0">Mostrando <strong><?php echo $total; ?> recursos</strong></p>
                        <form action="PuriskiriDescargar.php" method="get" id="ordenForm">
                            <?php if (!empty($buscar)) { ?><input type="hidden" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>"><?php } ?>
                            <?php if (!empty($categoria_filtro)) { ?><input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria_filtro); ?>"><?php } ?>
                            <?php if (!empty($nivel_filtro)) { ?><input type="hidden" name="nivel" value="<?php echo htmlspecialchars($nivel_filtro); ?>"><?php } ?>
                            <?php if (!empty($tipo_filtro)) { ?><input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo_filtro); ?>"><?php } ?>
                            <select class="form-select w-auto" name="orden" onchange="this.form.submit()">
                                <option value="recientes" <?php echo ($orden == 'recientes') ? 'selected' : ''; ?>>Mas recientes</option>
                                <option value="descargas" <?php echo ($orden == 'descargas') ? 'selected' : ''; ?>>Mas descargados</option>
                                <option value="az" <?php echo ($orden == 'az') ? 'selected' : ''; ?>>A-Z</option>
                                <option value="za" <?php echo ($orden == 'za') ? 'selected' : ''; ?>>Z-A</option>
                            </select>
                        </form>
                    </div>

                    <!-- GRID DE RECURSOS -->
                    <div class="row g-4">
                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while ($recurso = mysqli_fetch_assoc($resultado)) {
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
                                            <?php echo htmlspecialchars(substr($recurso['descripcion'], 0, 100)) . '...'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                                <h4>No se encontraron recursos</h4>
                                <p class="text-muted">Intenta con otros filtros o terminos de busqueda</p>
                                <a href="PuriskiriDescargar.php" class="btn btn-primary">Ver todos los recursos</a>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- PAGINACION -->
                    <?php if ($total_paginas > 1) { ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagina > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php $url_params['pagina'] = $pagina - 1; echo buildUrl($url_params); ?>">Anterior</a>
                            </li>
                            <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <?php } ?>

                            <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php $url_params['pagina'] = $i; echo buildUrl($url_params); ?>"><?php echo $i; ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($pagina < $total_paginas) { ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php $url_params['pagina'] = $pagina + 1; echo buildUrl($url_params); ?>">Siguiente</a>
                            </li>
                            <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <?php } ?>
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
