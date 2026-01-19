<?php
session_start();
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: Puriskiri.php");
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
$query = "SELECT * FROM puriskiri_recursos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: PuriskiriDescargar.php");
    die();
}

$recurso = mysqli_fetch_assoc($resultado);

// Verificar permisos
if ($_SESSION['rol'] != 'Administrador' && $recurso['usuario_id'] != $_SESSION['id']) {
    header("Location: PuriskiriDetalle.php?id=$id");
    die();
}

// Obtener categorías
$query_categorias = "SELECT * FROM puriskiri_categorias WHERE activo = 1 ORDER BY orden";
$categorias = mysqli_query($conexion, $query_categorias);

// Obtener niveles
$query_niveles = "SELECT * FROM puriskiri_niveles ORDER BY orden";
$niveles = mysqli_query($conexion, $query_niveles);

// Mensaje de éxito o error
$mensaje = '';
$tipo_mensaje = '';
if (isset($_GET['exito'])) {
    $mensaje = 'Recurso actualizado exitosamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    $mensaje = 'Error al actualizar el recurso.';
    $tipo_mensaje = 'danger';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Editar Recurso - PURISKIRI">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Editar Recurso - PURISKIRI</title>

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
                    <li class="breadcrumb-item"><a href="PuriskiriDetalle.php?id=<?php echo $id; ?>">Detalle</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- FORMULARIO DE EDICIÓN -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <h2 class="text-center mb-4">Editar Recurso</h2>

                    <?php if (!empty($mensaje)) { ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>

                    <div class="custom-text-box">
                        <form id="editForm" action="PHP/puriskiri_guardar_edicion.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $recurso['id']; ?>">

                            <!-- Titulo -->
                            <div class="mb-4">
                                <label for="titulo" class="form-label">Titulo del Recurso *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($recurso['titulo']); ?>" required maxlength="200">
                            </div>

                            <!-- Descripcion -->
                            <div class="mb-4">
                                <label for="descripcion" class="form-label">Descripcion *</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="6" required minlength="100"><?php echo htmlspecialchars($recurso['descripcion']); ?></textarea>
                                <small class="text-muted">Minimo 100 caracteres</small>
                            </div>

                            <!-- Tema/Categoria -->
                            <div class="mb-4">
                                <label for="categoria" class="form-label">Tema *</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $recurso['categoria_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['nombre']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Nivel Educativo -->
                            <div class="mb-4">
                                <label for="nivel" class="form-label">Nivel Educativo *</label>
                                <select class="form-select" id="nivel" name="nivel" required>
                                    <?php while ($niv = mysqli_fetch_assoc($niveles)) { ?>
                                    <option value="<?php echo $niv['id']; ?>" <?php echo ($niv['id'] == $recurso['nivel_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($niv['nombre']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Archivo actual -->
                            <div class="mb-4">
                                <label class="form-label">Archivo Actual</label>
                                <p class="text-muted">
                                    <i class="fas fa-file"></i>
                                    <?php echo basename($recurso['ruta_archivo']); ?>
                                    (<?php echo strtoupper($recurso['tipo_archivo']); ?>)
                                </p>
                            </div>

                            <!-- Nuevo archivo (opcional) -->
                            <div class="mb-4">
                                <label for="archivo" class="form-label">Reemplazar Archivo (Opcional)</label>
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.ppt,.pptx,.doc,.docx,.xlsx">
                                <small class="text-muted">Deja vacio para mantener el archivo actual</small>
                            </div>

                            <!-- Portada actual -->
                            <?php if (!empty($recurso['ruta_portada'])) { ?>
                            <div class="mb-4">
                                <label class="form-label">Portada Actual</label>
                                <div>
                                    <img src="<?php echo htmlspecialchars($recurso['ruta_portada']); ?>" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            </div>
                            <?php } ?>

                            <!-- Nueva portada (opcional) -->
                            <div class="mb-4">
                                <label for="portada" class="form-label">Cambiar Portada (Opcional)</label>
                                <input type="file" class="form-control" id="portada" name="portada" accept="image/jpeg,image/png,image/gif">
                                <small class="text-muted">Deja vacio para mantener la portada actual</small>
                            </div>

                            <!-- Autor -->
                            <div class="mb-4">
                                <label for="autor" class="form-label">Autor</label>
                                <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($recurso['autor']); ?>" maxlength="100">
                            </div>

                            <!-- Palabras Clave -->
                            <div class="mb-4">
                                <label for="palabras_clave" class="form-label">Palabras Clave</label>
                                <input type="text" class="form-control" id="palabras_clave" name="palabras_clave" value="<?php echo htmlspecialchars($recurso['palabras_clave']); ?>" maxlength="255">
                                <small class="text-muted">Separa las palabras con comas</small>
                            </div>

                            <!-- Opciones admin -->
                            <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="destacado" name="destacado" <?php echo $recurso['destacado'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="destacado">
                                        Marcar como destacado
                                    </label>
                                </div>
                            </div>
                            <?php } ?>

                            <!-- Botones -->
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="PuriskiriDetalle.php?id=<?php echo $id; ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
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
