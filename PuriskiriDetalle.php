<?php
session_start();
$roles_permitidos = ['Administrador', 'Docente', 'Usuario'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: SinLogin.php");
    session_destroy();
    die();
}

include "PHP/conexionBe.php";

// Obtener ID del recurso
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: PuriskiriDescargar.php");
    die();
}

// Obtener información del recurso
$query = "SELECT r.*, c.nombre as categoria_nombre, c.slug as categoria_slug, n.nombre as nivel_nombre, u.nombre_usuario
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    INNER JOIN usuarios u ON r.usuario_id = u.id
    WHERE r.id = $id AND r.activo = 1";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: PuriskiriDescargar.php");
    die();
}

$recurso = mysqli_fetch_assoc($resultado);

// Obtener recursos relacionados (misma categoría)
$query_relacionados = "SELECT r.*, c.nombre as categoria_nombre, n.nombre as nivel_nombre
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE r.categoria_id = " . $recurso['categoria_id'] . "
    AND r.id != $id
    AND r.activo = 1
    ORDER BY r.descargas DESC
    LIMIT 3";
$resultado_relacionados = mysqli_query($conexion, $query_relacionados);

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

// Calcular tamaño del archivo
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

$ruta_archivo = $recurso['ruta_archivo'];
$tamano_archivo = file_exists($ruta_archivo) ? formatBytes(filesize($ruta_archivo)) : 'N/A';

$portada = !empty($recurso['ruta_portada']) ? $recurso['ruta_portada'] : 'images/causes/group-people-volunteering-foodbank-poor-people.jpg';
$autor = !empty($recurso['autor']) ? $recurso['autor'] : 'Anonimo';

// Colores de badges
$colores_categoria = [
    'agua' => 'primary',
    'ambiente' => 'success',
    'agricultura' => 'warning',
    'alimentacion' => 'info',
    'clima' => 'danger',
    'biodiversidad' => 'secondary'
];
$color_categoria = isset($colores_categoria[$recurso['categoria_slug']]) ? $colores_categoria[$recurso['categoria_slug']] : 'primary';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php echo htmlspecialchars(substr($recurso['descripcion'], 0, 160)); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($autor); ?>">

    <title><?php echo htmlspecialchars($recurso['titulo']); ?> - PURISKIRI</title>

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
                    <li class="breadcrumb-item"><a href="PuriskiriDescargar.php">Catalogo</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($recurso['titulo']); ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- DETALLE DEL RECURSO -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <!-- Imagen de portada grande -->
                    <div class="resource-detail-image mb-4">
                        <img src="<?php echo htmlspecialchars($portada); ?>" class="img-fluid" alt="Portada del recurso">
                    </div>

                    <!-- Informacion principal -->
                    <div class="resource-detail-info mb-4">
                        <h2 class="mb-3"><?php echo htmlspecialchars($recurso['titulo']); ?></h2>

                        <!-- Metadata -->
                        <div class="resource-metadata mb-4">
                            <span class="badge bg-<?php echo $color_categoria; ?> me-2">
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($recurso['categoria_nombre']); ?>
                            </span>
                            <span class="badge bg-success me-2">
                                <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($recurso['nivel_nombre']); ?>
                            </span>
                            <span class="badge bg-warning me-2">
                                <i class="fas <?php echo getIconoTipo($recurso['tipo_archivo']); ?>"></i> <?php echo strtoupper($recurso['tipo_archivo']); ?>
                            </span>
                            <span class="badge bg-info">
                                <i class="fas fa-download"></i> <?php echo $recurso['descargas']; ?> descargas
                            </span>
                        </div>

                        <div class="metadata-details text-muted mb-4">
                            <p class="mb-1">
                                <i class="fas fa-calendar"></i> <strong>Publicado:</strong> <?php echo date('d \d\e F \d\e Y', strtotime($recurso['fecha_creacion'])); ?>
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-user"></i> <strong>Autor:</strong> <?php echo htmlspecialchars($autor); ?>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-file-alt"></i> <strong>Tamano:</strong> <?php echo $tamano_archivo; ?>
                            </p>
                        </div>

                        <!-- Descripcion completa -->
                        <div class="custom-text-box">
                            <h5 class="mb-3">Descripcion</h5>
                            <?php echo nl2br(htmlspecialchars($recurso['descripcion'])); ?>
                        </div>

                        <!-- Palabras Clave -->
                        <?php if (!empty($recurso['palabras_clave'])) {
                            $keywords = explode(',', $recurso['palabras_clave']);
                        ?>
                        <div class="mt-4">
                            <h6 class="mb-3">Palabras Clave:</h6>
                            <?php foreach ($keywords as $keyword) { ?>
                            <span class="badge bg-secondary me-2 mb-2"><?php echo htmlspecialchars(trim($keyword)); ?></span>
                            <?php } ?>
                        </div>
                        <?php } ?>

                        <!-- Boton de descarga grande -->
                        <div class="text-center my-5">
                            <a href="PHP/puriskiri_descargar.php?id=<?php echo $recurso['id']; ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-download"></i> Descargar Recurso (<?php echo $tamano_archivo; ?>)
                            </a>
                        </div>

                        <!-- Opciones de edición para propietario o admin -->
                        <?php if ($_SESSION['id'] == $recurso['usuario_id'] || $_SESSION['rol'] == 'Administrador') { ?>
                        <div class="text-center mb-4">
                            <a href="PuriskiriEditar.php?id=<?php echo $recurso['id']; ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Recursos relacionados -->
                    <?php if (mysqli_num_rows($resultado_relacionados) > 0) { ?>
                    <div class="related-resources">
                        <h4 class="mb-4">Recursos Relacionados</h4>
                        <div class="row g-4">
                            <?php while ($relacionado = mysqli_fetch_assoc($resultado_relacionados)) {
                                $portada_rel = !empty($relacionado['ruta_portada']) ? $relacionado['ruta_portada'] : 'images/causes/group-people-volunteering-foodbank-poor-people.jpg';
                            ?>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="resource-card-small">
                                    <img src="<?php echo htmlspecialchars($portada_rel); ?>" class="img-fluid rounded" alt="">
                                    <h6 class="mt-2">
                                        <a href="PuriskiriDetalle.php?id=<?php echo $relacionado['id']; ?>"><?php echo htmlspecialchars($relacionado['titulo']); ?></a>
                                    </h6>
                                    <p class="small text-muted">
                                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($relacionado['categoria_nombre']); ?><br>
                                        <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($relacionado['nivel_nombre']); ?> |
                                        <i class="fas <?php echo getIconoTipo($relacionado['tipo_archivo']); ?>"></i> <?php echo strtoupper($relacionado['tipo_archivo']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Botones de navegacion -->
                    <div class="text-center mt-5">
                        <a href="PuriskiriDescargar.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Catalogo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Estas seguro de que deseas eliminar este recurso?</p>
                <p class="text-muted"><strong><?php echo htmlspecialchars($recurso['titulo']); ?></strong></p>
                <p class="text-danger small">Esta accion no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="PHP/puriskiri_eliminar_recurso.php?id=<?php echo $recurso['id']; ?>" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<?php include "modal_cierre.php"; ?>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>

</body>

</html>
