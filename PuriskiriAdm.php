<?php
session_start();
$roles_permitidos = ['Administrador'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ConLogin.php");
    die();
}

include "PHP/conexionBe.php";

// Parámetros de filtro
$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 15;
$offset = ($pagina - 1) * $por_pagina;

// Construir consulta
$where = "1=1";
if (!empty($buscar)) {
    $where .= " AND (r.titulo LIKE '%$buscar%' OR r.descripcion LIKE '%$buscar%')";
}

// Consulta principal
$query = "SELECT r.*, c.nombre as categoria_nombre, n.nombre as nivel_nombre, u.nombre_usuario
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    INNER JOIN usuarios u ON r.usuario_id = u.id
    WHERE $where
    ORDER BY r.fecha_creacion DESC
    LIMIT $offset, $por_pagina";
$resultado = mysqli_query($conexion, $query);

// Contar total
$query_count = "SELECT COUNT(*) as total FROM puriskiri_recursos r WHERE $where";
$resultado_count = mysqli_query($conexion, $query_count);
$total = mysqli_fetch_assoc($resultado_count)['total'];
$total_paginas = ceil($total / $por_pagina);

// Estadísticas
$query_stats = "SELECT
    COUNT(*) as total_recursos,
    SUM(descargas) as total_descargas,
    SUM(destacado) as total_destacados,
    SUM(activo = 0) as total_inactivos
    FROM puriskiri_recursos";
$stats = mysqli_fetch_assoc(mysqli_query($conexion, $query_stats));

// Mensaje de acción
$mensaje = '';
$tipo_mensaje = '';
if (isset($_GET['destacado'])) {
    $mensaje = 'Recurso marcado como destacado.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['nodestacado'])) {
    $mensaje = 'Recurso desmarcado de destacados.';
    $tipo_mensaje = 'info';
} elseif (isset($_GET['eliminado'])) {
    $mensaje = 'Recurso eliminado correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['activado'])) {
    $mensaje = 'Recurso activado.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['desactivado'])) {
    $mensaje = 'Recurso desactivado.';
    $tipo_mensaje = 'warning';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Administracion de PURISKIRI">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Administracion PURISKIRI - Terra ConsCiencia</title>

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
                    <li class="breadcrumb-item active" aria-current="page">Administracion</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-4">Panel de Administracion PURISKIRI</h2>

            <?php if (!empty($mensaje)) { ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-primary"><?php echo $stats['total_recursos'] ?: 0; ?></h3>
                        <p class="mb-0">Total Recursos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-success"><?php echo $stats['total_descargas'] ?: 0; ?></h3>
                        <p class="mb-0">Total Descargas</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-warning"><?php echo $stats['total_destacados'] ?: 0; ?></h3>
                        <p class="mb-0">Destacados</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="custom-text-box text-center">
                        <h3 class="text-danger"><?php echo $stats['total_inactivos'] ?: 0; ?></h3>
                        <p class="mb-0">Inactivos</p>
                    </div>
                </div>
            </div>

            <!-- Barra de acciones -->
            <div class="row mb-4">
                <div class="col-lg-6 col-12 mb-3">
                    <form action="PuriskiriAdm.php" method="get" class="d-flex">
                        <input type="text" class="form-control me-2" name="buscar" placeholder="Buscar recursos..." value="<?php echo htmlspecialchars($buscar); ?>">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col-lg-6 col-12 text-lg-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#configModal">
                        <i class="fas fa-cog"></i> Configuracion
                    </button>
                    <a href="PuriskiriCategoriasAdm.php" class="btn btn-info me-2">
                        <i class="fas fa-tags"></i> Gestionar Categorias
                    </a>
                    <a href="PuriskiriSubir.php" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Recurso
                    </a>
                </div>
            </div>

            <!-- Tabla de recursos -->
            <div class="table-responsive custom-text-box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titulo</th>
                            <th>Categoria</th>
                            <th>Nivel</th>
                            <th>Tipo</th>
                            <th>Descargas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while ($recurso = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $recurso['id']; ?></td>
                                <td>
                                    <a href="PuriskiriDetalle.php?id=<?php echo $recurso['id']; ?>" target="_blank">
                                        <?php echo htmlspecialchars(substr($recurso['titulo'], 0, 40)) . (strlen($recurso['titulo']) > 40 ? '...' : ''); ?>
                                    </a>
                                    <?php if ($recurso['destacado']) { ?>
                                    <span class="badge bg-warning"><i class="fas fa-star"></i></span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($recurso['categoria_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($recurso['nivel_nombre']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo strtoupper($recurso['tipo_archivo']); ?></span></td>
                                <td><?php echo $recurso['descargas']; ?></td>
                                <td>
                                    <?php if ($recurso['activo']) { ?>
                                    <span class="badge bg-success">Activo</span>
                                    <?php } else { ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Destacar/Quitar destacado -->
                                        <?php if ($recurso['destacado']) { ?>
                                        <a href="PHP/puriskiri_actualizar_recurso.php?id=<?php echo $recurso['id']; ?>&accion=nodestacado" class="btn btn-outline-warning" title="Quitar destacado">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <?php } else { ?>
                                        <a href="PHP/puriskiri_actualizar_recurso.php?id=<?php echo $recurso['id']; ?>&accion=destacado" class="btn btn-outline-secondary" title="Marcar destacado">
                                            <i class="far fa-star"></i>
                                        </a>
                                        <?php } ?>

                                        <!-- Activar/Desactivar -->
                                        <?php if ($recurso['activo']) { ?>
                                        <a href="PHP/puriskiri_actualizar_recurso.php?id=<?php echo $recurso['id']; ?>&accion=desactivar" class="btn btn-outline-danger" title="Desactivar">
                                            <i class="fas fa-eye-slash"></i>
                                        </a>
                                        <?php } else { ?>
                                        <a href="PHP/puriskiri_actualizar_recurso.php?id=<?php echo $recurso['id']; ?>&accion=activar" class="btn btn-outline-success" title="Activar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php } ?>

                                        <!-- Editar -->
                                        <a href="PuriskiriEditar.php?id=<?php echo $recurso['id']; ?>" class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Eliminar -->
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $recurso['id']; ?>" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de eliminación -->
                                    <div class="modal fade" id="eliminarModal<?php echo $recurso['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminacion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Eliminar el recurso:</p>
                                                    <p><strong><?php echo htmlspecialchars($recurso['titulo']); ?></strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="PHP/puriskiri_eliminar_recurso.php?id=<?php echo $recurso['id']; ?>&admin=1" class="btn btn-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <p class="text-muted mb-0">No hay recursos registrados.</p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginacion -->
            <?php if ($total_paginas > 1) { ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($pagina > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="PuriskiriAdm.php?pagina=<?php echo $pagina - 1; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?>">Anterior</a>
                    </li>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                        <a class="page-link" href="PuriskiriAdm.php?pagina=<?php echo $i; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php } ?>

                    <?php if ($pagina < $total_paginas) { ?>
                    <li class="page-item">
                        <a class="page-link" href="PuriskiriAdm.php?pagina=<?php echo $pagina + 1; ?><?php echo !empty($buscar) ? '&buscar=' . urlencode($buscar) : ''; ?>">Siguiente</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </section>
</main>

<?php include "footer.php"; ?>
<?php include "modal_cierre.php"; ?>

<!-- Modal de Configuración PURISKIRI -->
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="configModalLabel"><i class="fas fa-cog"></i> Configuracion PURISKIRI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="configForm">
                    <!-- Límite de tamaño de archivo -->
                    <div class="mb-4">
                        <label for="limite_archivo_mb" class="form-label">
                            <i class="fas fa-file-upload"></i> Limite maximo de archivo (MB)
                        </label>
                        <input type="number" class="form-control" id="limite_archivo_mb" name="limite_archivo_mb"
                               min="1" max="150" value="100" required>
                        <small class="text-muted">Rango permitido: 1 MB - 150 MB. Los usuarios no podran subir archivos mas grandes que este limite.</small>
                    </div>

                    <!-- Información del servidor -->
                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> El servidor esta configurado para aceptar hasta 150 MB.
                            Este ajuste limita el tamaño que los usuarios pueden subir.
                        </small>
                    </div>
                </form>

                <!-- Mensaje de estado -->
                <div id="configMensaje" class="mt-3" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarConfig">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>

<script>
// Cargar configuración al abrir el modal
$('#configModal').on('show.bs.modal', function () {
    $.ajax({
        url: 'PHP/puriskiri_obtener_config.php',
        method: 'GET',
        data: { clave: 'limite_archivo_mb' },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.valor) {
                $('#limite_archivo_mb').val(response.valor);
            }
        },
        error: function() {
            console.error('Error al cargar configuración');
        }
    });
    $('#configMensaje').hide();
});

// Guardar configuración
$('#btnGuardarConfig').on('click', function() {
    var btn = $(this);
    var limite = $('#limite_archivo_mb').val();

    // Validar
    if (limite < 1 || limite > 150) {
        mostrarMensajeConfig('El límite debe estar entre 1 y 150 MB.', 'danger');
        return;
    }

    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

    $.ajax({
        url: 'PHP/puriskiri_guardar_config.php',
        method: 'POST',
        data: {
            clave: 'limite_archivo_mb',
            valor: limite
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                mostrarMensajeConfig('Configuración guardada correctamente.', 'success');
            } else {
                mostrarMensajeConfig(response.error || 'Error al guardar.', 'danger');
            }
        },
        error: function() {
            mostrarMensajeConfig('Error de conexión. Intenta nuevamente.', 'danger');
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Cambios');
        }
    });
});

function mostrarMensajeConfig(mensaje, tipo) {
    $('#configMensaje')
        .removeClass('alert-success alert-danger alert-info')
        .addClass('alert alert-' + tipo)
        .html(mensaje)
        .show();
}
</script>

</body>

</html>
