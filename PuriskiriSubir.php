<?php
session_start();
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: Puriskiri.php");
    die();
}

include "PHP/conexionBe.php";

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
    $mensaje = 'Recurso subido exitosamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    $mensaje = 'Error al subir el recurso. Por favor, intenta nuevamente.';
    $tipo_mensaje = 'danger';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Subir Recursos Educativos - PURISKIRI">
    <meta name="author" content="Fundacion Gaia Pacha">

    <title>Subir Recursos - PURISKIRI</title>

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
                    <li class="breadcrumb-item active" aria-current="page">Subir Recurso</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- FORMULARIO DE SUBIDA -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <h2 class="text-center mb-4">Subir Nuevo Recurso</h2>
                    <p class="text-center text-muted mb-5">Comparte tus materiales educativos con la comunidad de docentes</p>

                    <?php if (!empty($mensaje)) { ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>

                    <div class="custom-text-box">
                        <form id="uploadForm" action="PHP/puriskiri_subir_recurso.php" method="post" enctype="multipart/form-data">
                            <!-- Titulo -->
                            <div class="mb-4">
                                <label for="titulo" class="form-label">Titulo del Recurso *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Cartilla sobre Seguridad Hidrica" required maxlength="200">
                                <small class="text-muted">Usa un titulo descriptivo y claro</small>
                            </div>

                            <!-- Descripcion -->
                            <div class="mb-4">
                                <label for="descripcion" class="form-label">Descripcion *</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe el contenido del recurso, objetivos de aprendizaje y como puede ser utilizado en clase..." required minlength="100"></textarea>
                                <small class="text-muted">Minimo 100 caracteres</small>
                            </div>

                            <!-- Tema/Categoria -->
                            <div class="mb-4">
                                <label for="categoria" class="form-label">Tema *</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="">Selecciona un tema...</option>
                                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Nivel Educativo -->
                            <div class="mb-4">
                                <label for="nivel" class="form-label">Nivel Educativo *</label>
                                <select class="form-select" id="nivel" name="nivel" required>
                                    <option value="">Selecciona un nivel...</option>
                                    <?php while ($niv = mysqli_fetch_assoc($niveles)) { ?>
                                    <option value="<?php echo $niv['id']; ?>"><?php echo htmlspecialchars($niv['nombre']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Carga de Archivo -->
                            <div class="mb-4">
                                <label for="archivo" class="form-label">Archivo del Recurso *</label>
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.ppt,.pptx,.doc,.docx,.xlsx" required>
                                <small class="text-muted">Formatos permitidos: PDF, PPT, PPTX, DOC, DOCX, XLSX (Max. 50MB)</small>
                            </div>

                            <!-- Imagen de Portada -->
                            <div class="mb-4">
                                <label for="portada" class="form-label">Imagen de Portada (Opcional)</label>
                                <input type="file" class="form-control" id="portada" name="portada" accept="image/jpeg,image/png,image/gif">
                                <small class="text-muted">Imagen representativa del recurso (JPG, PNG, max. 5MB)</small>
                            </div>

                            <!-- Autor -->
                            <div class="mb-4">
                                <label for="autor" class="form-label">Autor (Opcional)</label>
                                <input type="text" class="form-control" id="autor" name="autor" placeholder="Tu nombre o pseudonimo" maxlength="100">
                                <small class="text-muted">Si no lo especificas, aparecera como "Anonimo"</small>
                            </div>

                            <!-- Palabras Clave -->
                            <div class="mb-4">
                                <label for="palabras_clave" class="form-label">Palabras Clave (Opcional)</label>
                                <input type="text" class="form-control" id="palabras_clave" name="palabras_clave" placeholder="Ej: agua, conservacion, huella hidrica" maxlength="255">
                                <small class="text-muted">Separa las palabras con comas. Ayudan a que otros encuentren tu recurso.</small>
                            </div>

                            <!-- Terminos y Condiciones -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terminos" name="terminos" required>
                                    <label class="form-check-label" for="terminos">
                                        Acepto los terminos y condiciones. Confirmo que tengo los derechos para compartir este material. *
                                    </label>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-upload"></i> Subir Recurso
                                </button>
                                <a href="Puriskiri.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Informacion Adicional -->
                    <div class="mt-5">
                        <div class="custom-text-box">
                            <h5 class="mb-3"><i class="fas fa-lightbulb"></i> Consejos para Subir Recursos</h5>
                            <ul>
                                <li>Asegurate de que el titulo sea descriptivo y facil de buscar</li>
                                <li>Proporciona una descripcion detallada que incluya objetivos y contenidos</li>
                                <li>Verifica que el archivo este en buen estado y sea legible</li>
                                <li>Usa una imagen de portada atractiva para llamar la atencion</li>
                                <li>Las palabras clave ayudan a otros docentes a encontrar tu recurso</li>
                            </ul>
                        </div>
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

<script>
// Validación del formulario
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    var descripcion = document.getElementById('descripcion').value;
    if (descripcion.length < 100) {
        e.preventDefault();
        alert('La descripcion debe tener al menos 100 caracteres.');
        return false;
    }
});
</script>

</body>

</html>
