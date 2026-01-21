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

// Obtener límite de archivo desde configuración
$query_config = "SELECT valor FROM puriskiri_config WHERE clave = 'limite_archivo_mb'";
$result_config = mysqli_query($conexion, $query_config);
$limite_archivo_mb = 100; // Valor por defecto
if ($result_config && mysqli_num_rows($result_config) > 0) {
    $config_row = mysqli_fetch_assoc($result_config);
    $limite_archivo_mb = (int)$config_row['valor'];
}

// Mensaje de éxito o error
$mensaje = '';
$tipo_mensaje = '';
if (isset($_GET['exito'])) {
    $mensaje = 'Recurso subido exitosamente.';
    $tipo_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    $error_tipo = $_GET['error'];
    $tipo_mensaje = 'danger';

    // Mensajes específicos según el tipo de error
    switch ($error_tipo) {
        case 'campos':
            $mensaje = 'Por favor completa todos los campos requeridos.';
            break;
        case 'descripcion':
            $mensaje = 'La descripción debe tener al menos 100 caracteres.';
            break;
        case 'archivo':
            $mensaje = 'Debes seleccionar un archivo para subir.';
            break;
        case 'extension':
            $mensaje = 'Tipo de archivo no permitido. Solo se aceptan: PDF, PPT, PPTX, DOC, DOCX, XLSX.';
            break;
        case 'tamano':
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : $limite_archivo_mb;
            $mensaje = "El archivo excede el tamaño máximo permitido de {$limite} MB.";
            break;
        case 'upload':
            $mensaje = 'Error al guardar el archivo. Verifica los permisos del servidor.';
            break;
        case 'db':
            $mensaje = 'Error al guardar en la base de datos. Intenta nuevamente.';
            break;
        default:
            $mensaje = 'Error al subir el recurso. Por favor, intenta nuevamente.';
    }
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

    <!-- Tagify CSS para palabras clave -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    <style>
    /* Estilos personalizados para la subida */
    .upload-progress-container {
        display: none;
    }
    .upload-progress-container.active {
        display: block;
    }
    .progress {
        height: 25px;
        border-radius: 15px;
    }
    .progress-bar {
        transition: width 0.3s ease;
        font-weight: bold;
    }
    /* Tagify personalizado */
    .tagify {
        --tags-border-color: #ced4da;
        --tags-hover-border-color: #b4c7e7;
        --tags-focus-border-color: #86b7fe;
        border-radius: 0.375rem;
    }
    .tagify__tag {
        --tag-bg: #e3f2fd;
        --tag-text-color: #1565c0;
    }
    .tagify__tag__removeBtn:hover {
        background: #ef5350;
    }
    /* Mensaje de error en campo */
    .campo-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
    .campo-error-msg {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    </style>
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

                    <!-- Mensajes del servidor (PHP) -->
                    <?php if (!empty($mensaje)) { ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>

                    <!-- Mensajes AJAX -->
                    <div id="mensaje-ajax" class="alert" role="alert" style="display: none;"></div>

                    <!-- Barra de Progreso -->
                    <div id="upload-progress" class="upload-progress-container mb-4">
                        <div class="custom-text-box">
                            <h5 class="mb-3"><i class="fas fa-cloud-upload-alt"></i> Subiendo archivo...</h5>
                            <div class="progress mb-2">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">0%</div>
                            </div>
                            <p id="progress-text" class="text-muted mb-0">Preparando subida...</p>
                        </div>
                    </div>

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
                                <small class="text-muted">Formatos permitidos: PDF, PPT, PPTX, DOC, DOCX, XLSX (Max. <span id="limite-archivo-display"><?php echo $limite_archivo_mb; ?></span>MB)</small>
                                <div id="archivo-error" class="campo-error-msg" style="display: none;"></div>
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

<!-- Tagify JS para palabras clave -->
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<script>
// Configuración global
var CONFIG = {
    limiteArchivoMB: <?php echo $limite_archivo_mb; ?>,
    extensionesPermitidas: ['pdf', 'ppt', 'pptx', 'doc', 'docx', 'xlsx']
};

// Inicializar Tagify para palabras clave
var inputPalabrasClave = document.getElementById('palabras_clave');
var tagify = new Tagify(inputPalabrasClave, {
    maxTags: 10,
    placeholder: 'Escribe y presiona Enter',
    dropdown: {
        maxItems: 10,
        enabled: 0, // Mostrar dropdown al escribir
        closeOnSelect: false
    },
    whitelist: [],
    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', ')
});

// Cargar sugerencias de palabras clave existentes
$.ajax({
    url: 'PHP/puriskiri_obtener_palabras_clave.php',
    dataType: 'json',
    success: function(data) {
        tagify.whitelist = data;
    }
});

// Búsqueda dinámica de palabras clave
tagify.on('input', function(e) {
    var value = e.detail.value;
    if (value.length >= 2) {
        $.ajax({
            url: 'PHP/puriskiri_obtener_palabras_clave.php',
            data: { q: value },
            dataType: 'json',
            success: function(data) {
                tagify.whitelist = data;
                tagify.dropdown.show(value);
            }
        });
    }
});

// Validación de archivo al seleccionar
$('#archivo').on('change', function() {
    var input = this;
    var errorDiv = $('#archivo-error');

    // Limpiar errores previos
    $(this).removeClass('campo-error');
    errorDiv.hide().text('');

    if (input.files && input.files[0]) {
        var archivo = input.files[0];
        var nombreArchivo = archivo.name;
        var extension = nombreArchivo.split('.').pop().toLowerCase();
        var tamanoMB = (archivo.size / (1024 * 1024)).toFixed(2);

        // Validar extensión
        if (CONFIG.extensionesPermitidas.indexOf(extension) === -1) {
            $(this).addClass('campo-error');
            errorDiv.text('Tipo de archivo no permitido. Solo: ' + CONFIG.extensionesPermitidas.join(', ').toUpperCase()).show();
            this.value = '';
            return;
        }

        // Validar tamaño
        if (archivo.size > CONFIG.limiteArchivoMB * 1024 * 1024) {
            $(this).addClass('campo-error');
            errorDiv.text('El archivo (' + tamanoMB + ' MB) excede el límite de ' + CONFIG.limiteArchivoMB + ' MB.').show();
            this.value = '';
            return;
        }
    }
});

// Envío del formulario con AJAX
$('#uploadForm').on('submit', function(e) {
    e.preventDefault();

    // Validaciones del lado del cliente
    var descripcion = $('#descripcion').val();
    if (descripcion.length < 100) {
        mostrarMensaje('La descripción debe tener al menos 100 caracteres. Actualmente tiene ' + descripcion.length + '.', 'danger');
        $('#descripcion').focus();
        return false;
    }

    var archivoInput = document.getElementById('archivo');
    if (!archivoInput.files || !archivoInput.files[0]) {
        mostrarMensaje('Debes seleccionar un archivo para subir.', 'danger');
        return false;
    }

    var archivo = archivoInput.files[0];
    var extension = archivo.name.split('.').pop().toLowerCase();

    // Validar extensión
    if (CONFIG.extensionesPermitidas.indexOf(extension) === -1) {
        mostrarMensaje('Tipo de archivo no permitido. Solo se aceptan: ' + CONFIG.extensionesPermitidas.join(', ').toUpperCase(), 'danger');
        return false;
    }

    // Validar tamaño
    if (archivo.size > CONFIG.limiteArchivoMB * 1024 * 1024) {
        var tamanoMB = (archivo.size / (1024 * 1024)).toFixed(2);
        mostrarMensaje('El archivo (' + tamanoMB + ' MB) excede el límite de ' + CONFIG.limiteArchivoMB + ' MB.', 'danger');
        return false;
    }

    // Preparar FormData
    var formData = new FormData(this);

    // Mostrar barra de progreso
    $('#upload-progress').addClass('active');
    $('#uploadForm').hide();
    ocultarMensaje();

    // Enviar vía AJAX
    $.ajax({
        url: 'PHP/puriskiri_subir_recurso_ajax.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(evt) {
                if (evt.lengthComputable) {
                    var porcentaje = Math.round((evt.loaded / evt.total) * 100);
                    $('#progress-bar').css('width', porcentaje + '%').text(porcentaje + '%');

                    if (porcentaje < 30) {
                        $('#progress-text').text('Subiendo archivo...');
                    } else if (porcentaje < 70) {
                        $('#progress-text').text('Procesando...');
                    } else if (porcentaje < 100) {
                        $('#progress-text').text('Casi listo...');
                    } else {
                        $('#progress-text').text('Guardando en el servidor...');
                    }
                }
            });
            return xhr;
        },
        success: function(response) {
            $('#upload-progress').removeClass('active');

            if (response.success) {
                $('#progress-bar').removeClass('bg-primary').addClass('bg-success').text('Completado');
                mostrarMensaje('<i class="fas fa-check-circle"></i> ' + response.mensaje, 'success');

                // Limpiar formulario
                $('#uploadForm')[0].reset();
                tagify.removeAllTags();
                $('#uploadForm').show();

                // Opción: redirigir después de un momento
                setTimeout(function() {
                    if (confirm('¿Deseas subir otro recurso?')) {
                        window.location.reload();
                    } else {
                        window.location.href = 'Puriskiri.php';
                    }
                }, 1500);
            } else {
                $('#uploadForm').show();
                var mensajeError = response.error || 'Error desconocido al subir el recurso.';
                mostrarMensaje('<i class="fas fa-exclamation-circle"></i> ' + mensajeError, 'danger');

                // Resaltar campo con error si se especifica
                if (response.detalles && response.detalles.campo) {
                    $('#' + response.detalles.campo).addClass('campo-error').focus();
                }
            }
        },
        error: function(xhr, status, error) {
            $('#upload-progress').removeClass('active');
            $('#uploadForm').show();

            var mensajeError = 'Error de conexión. ';
            if (xhr.status === 413) {
                mensajeError = 'El archivo es demasiado grande para el servidor.';
            } else if (xhr.status === 0) {
                mensajeError += 'Verifica tu conexión a internet.';
            } else {
                mensajeError += 'Por favor, intenta nuevamente.';
            }

            mostrarMensaje('<i class="fas fa-exclamation-triangle"></i> ' + mensajeError, 'danger');
        }
    });
});

// Funciones auxiliares para mensajes
function mostrarMensaje(texto, tipo) {
    $('#mensaje-ajax')
        .removeClass('alert-success alert-danger alert-warning alert-info')
        .addClass('alert-' + tipo)
        .html(texto)
        .show();

    // Scroll hacia arriba para ver el mensaje
    $('html, body').animate({ scrollTop: $('#mensaje-ajax').offset().top - 100 }, 300);
}

function ocultarMensaje() {
    $('#mensaje-ajax').hide();
}

// Limpiar resaltado de error al editar un campo
$('input, textarea, select').on('focus', function() {
    $(this).removeClass('campo-error');
});
</script>

</body>

</html>
