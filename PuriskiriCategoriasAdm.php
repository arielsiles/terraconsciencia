<?php
session_start();
$roles_permitidos = ['Administrador'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ConLogin.php");
    die();
}

include "PHP/conexionBe.php";

// Obtener todas las categorias (activas e inactivas)
$query = "SELECT c.*,
    (SELECT COUNT(*) FROM puriskiri_recursos r WHERE r.categoria_id = c.id) as total_recursos,
    (SELECT COUNT(*) FROM puriskiri_recursos r WHERE r.categoria_id = c.id AND r.activo = 1) as recursos_activos
    FROM puriskiri_categorias c
    ORDER BY c.orden, c.nombre";
$resultado = mysqli_query($conexion, $query);

// Mensaje de accion
$mensaje = '';
$tipo_mensaje = '';
if (isset($_GET['agregada'])) {
    $mensaje = 'Categoria agregada correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['editada'])) {
    $mensaje = 'Categoria actualizada correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['eliminada'])) {
    $mensaje = 'Categoria eliminada correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['inactivada'])) {
    $mensaje = 'Categoria inactivada. No se puede eliminar porque tiene recursos asociados.';
    $tipo_mensaje = 'warning';
} elseif (isset($_GET['activada'])) {
    $mensaje = 'Categoria activada correctamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    $mensaje = 'Error al procesar la solicitud. Intenta nuevamente.';
    $tipo_mensaje = 'danger';
} elseif (isset($_GET['error_duplicado'])) {
    $mensaje = 'Ya existe una categoria con ese nombre o slug.';
    $tipo_mensaje = 'danger';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Gestion de Categorias - PURISKIRI">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Gestion de Categorias - PURISKIRI</title>

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
                    <li class="breadcrumb-item"><a href="PuriskiriAdm.php">Administracion</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-4">Gestion de Categorias</h2>

            <?php if (!empty($mensaje)) { ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <!-- Barra de acciones -->
            <div class="row mb-4">
                <div class="col-lg-6 col-12 mb-3">
                    <a href="PuriskiriAdm.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Recursos
                    </a>
                </div>
                <div class="col-lg-6 col-12 text-lg-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">
                        <i class="fas fa-plus"></i> Nueva Categoria
                    </button>
                </div>
            </div>

            <!-- Tabla de categorias -->
            <div class="table-responsive custom-text-box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Slug</th>
                            <th>Descripcion</th>
                            <th>Recursos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while ($categoria = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $categoria['orden']; ?></td>
                                <td>
                                    <?php if (!empty($categoria['imagen'])) { ?>
                                    <img src="<?php echo htmlspecialchars($categoria['imagen']); ?>" alt="Portada" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    <?php } else { ?>
                                    <span class="text-muted small">Sin imagen</span>
                                    <?php } ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong></td>
                                <td><code><?php echo htmlspecialchars($categoria['slug']); ?></code></td>
                                <td><?php echo htmlspecialchars(substr($categoria['descripcion'] ?? '', 0, 50)) . (strlen($categoria['descripcion'] ?? '') > 50 ? '...' : ''); ?></td>
                                <td>
                                    <span class="badge bg-info"><?php echo $categoria['recursos_activos']; ?> activos</span>
                                    <?php if ($categoria['total_recursos'] > $categoria['recursos_activos']) { ?>
                                    <span class="badge bg-secondary"><?php echo $categoria['total_recursos'] - $categoria['recursos_activos']; ?> inactivos</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($categoria['activo']) { ?>
                                    <span class="badge bg-success">Activa</span>
                                    <?php } else { ?>
                                    <span class="badge bg-danger">Inactiva</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Editar -->
                                        <button type="button" class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editarModal"
                                            data-id="<?php echo $categoria['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($categoria['nombre']); ?>"
                                            data-slug="<?php echo htmlspecialchars($categoria['slug']); ?>"
                                            data-descripcion="<?php echo htmlspecialchars($categoria['descripcion'] ?? ''); ?>"
                                            data-orden="<?php echo $categoria['orden']; ?>"
                                            data-imagen="<?php echo htmlspecialchars($categoria['imagen'] ?? ''); ?>"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Activar/Desactivar -->
                                        <?php if ($categoria['activo']) { ?>
                                        <a href="PHP/puriskiri_eliminar_categoria.php?id=<?php echo $categoria['id']; ?>&accion=inactivar" class="btn btn-outline-warning" title="Inactivar">
                                            <i class="fas fa-eye-slash"></i>
                                        </a>
                                        <?php } else { ?>
                                        <a href="PHP/puriskiri_eliminar_categoria.php?id=<?php echo $categoria['id']; ?>&accion=activar" class="btn btn-outline-success" title="Activar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php } ?>

                                        <!-- Eliminar -->
                                        <button type="button" class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#eliminarModal<?php echo $categoria['id']; ?>"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de eliminacion -->
                                    <div class="modal fade" id="eliminarModal<?php echo $categoria['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminacion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if ($categoria['total_recursos'] > 0) { ?>
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        Esta categoria tiene <strong><?php echo $categoria['total_recursos']; ?> recursos</strong> asociados.
                                                        Se <strong>inactivara</strong> en lugar de eliminarse.
                                                    </div>
                                                    <?php } else { ?>
                                                    <p>Se eliminara permanentemente la categoria:</p>
                                                    <?php } ?>
                                                    <p><strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="PHP/puriskiri_eliminar_categoria.php?id=<?php echo $categoria['id']; ?>&accion=eliminar" class="btn btn-danger">
                                                        <?php echo ($categoria['total_recursos'] > 0) ? 'Inactivar' : 'Eliminar'; ?>
                                                    </a>
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
                                <p class="text-muted mb-0">No hay categorias registradas.</p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Informacion -->
            <div class="mt-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Nota:</strong> Las categorias con recursos asociados no se pueden eliminar, solo inactivar.
                    Las categorias inactivas no aparecen en el formulario de subida de recursos.
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Agregar Categoria -->
<div class="modal fade" id="agregarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="PHP/puriskiri_agregar_categoria.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agregar_nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="agregar_nombre" name="nombre" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="agregar_slug" class="form-label">Slug *</label>
                        <input type="text" class="form-control" id="agregar_slug" name="slug" required maxlength="50" pattern="[a-z0-9-]+">
                        <small class="text-muted">Solo letras minusculas, numeros y guiones. Ej: seguridad-hidrica</small>
                    </div>
                    <div class="mb-3">
                        <label for="agregar_descripcion" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="agregar_descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="agregar_imagen" class="form-label">Imagen de Portada</label>
                        <input type="file" class="form-control" id="agregar_imagen" name="imagen" accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">JPG, PNG o GIF. Maximo 5MB. Recomendado: 800x600px</small>
                    </div>
                    <div class="mb-3">
                        <label for="agregar_orden" class="form-label">Orden</label>
                        <input type="number" class="form-control" id="agregar_orden" name="orden" value="0" min="0">
                        <small class="text-muted">Numero para ordenar las categorias (menor = primero)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Categoria -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="PHP/puriskiri_editar_categoria.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="editar_id" name="id">
                <input type="hidden" id="editar_imagen_actual" name="imagen_actual">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="editar_slug" class="form-label">Slug *</label>
                        <input type="text" class="form-control" id="editar_slug" name="slug" required maxlength="50" pattern="[a-z0-9-]+">
                        <small class="text-muted">Solo letras minusculas, numeros y guiones</small>
                    </div>
                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="editar_descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editar_imagen" class="form-label">Imagen de Portada</label>
                        <div id="editar_imagen_preview" class="mb-2" style="display: none;">
                            <img src="" alt="Imagen actual" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 4px;">
                            <p class="small text-muted mt-1">Imagen actual</p>
                        </div>
                        <input type="file" class="form-control" id="editar_imagen" name="imagen" accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">JPG, PNG o GIF. Maximo 5MB. Dejar vacio para mantener la imagen actual.</small>
                    </div>
                    <div class="mb-3">
                        <label for="editar_orden" class="form-label">Orden</label>
                        <input type="number" class="form-control" id="editar_orden" name="orden" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<?php include "modal_cierre.php"; ?>

<!-- JAVASCRIPT FILES -->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>

<script>
// Auto-generar slug desde el nombre
document.getElementById('agregar_nombre').addEventListener('input', function() {
    var slug = this.value.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remover acentos
        .replace(/[^a-z0-9\s-]/g, '') // Solo alfanumericos
        .replace(/\s+/g, '-') // Espacios a guiones
        .replace(/-+/g, '-') // Multiples guiones a uno
        .trim();
    document.getElementById('agregar_slug').value = slug;
});

// Cargar datos en modal de edicion
var editarModal = document.getElementById('editarModal');
editarModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    document.getElementById('editar_id').value = button.getAttribute('data-id');
    document.getElementById('editar_nombre').value = button.getAttribute('data-nombre');
    document.getElementById('editar_slug').value = button.getAttribute('data-slug');
    document.getElementById('editar_descripcion').value = button.getAttribute('data-descripcion');
    document.getElementById('editar_orden').value = button.getAttribute('data-orden');

    // Manejar imagen actual
    var imagenActual = button.getAttribute('data-imagen');
    document.getElementById('editar_imagen_actual').value = imagenActual;
    var previewContainer = document.getElementById('editar_imagen_preview');

    if (imagenActual && imagenActual.trim() !== '') {
        previewContainer.style.display = 'block';
        previewContainer.querySelector('img').src = imagenActual;
    } else {
        previewContainer.style.display = 'none';
    }

    // Limpiar el input de archivo
    document.getElementById('editar_imagen').value = '';
});
</script>

</body>

</html>
