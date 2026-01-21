<?php
session_start();

// Verificar permisos de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: ../ConLogin.php");
    die();
}

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

include "conexionBe.php";

// Obtener y sanitizar datos
$id = (int)($_POST['id'] ?? 0);
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre'] ?? ''));
$slug = mysqli_real_escape_string($conexion, trim($_POST['slug'] ?? ''));
$descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
$orden = (int)($_POST['orden'] ?? 0);
$imagen_actual = trim($_POST['imagen_actual'] ?? '');

// Validar datos requeridos
if ($id <= 0 || empty($nombre) || empty($slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Validar formato del slug (solo minusculas, numeros y guiones)
if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Verificar que la categoria existe
$query_exists = "SELECT id, imagen FROM puriskiri_categorias WHERE id = $id";
$resultado_exists = mysqli_query($conexion, $query_exists);

if (mysqli_num_rows($resultado_exists) == 0) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

$categoria_actual = mysqli_fetch_assoc($resultado_exists);

// Verificar que no exista otra categoria con el mismo nombre o slug
$query_check = "SELECT id FROM puriskiri_categorias WHERE (nombre = '$nombre' OR slug = '$slug') AND id != $id";
$resultado_check = mysqli_query($conexion, $query_check);

if (mysqli_num_rows($resultado_check) > 0) {
    header("Location: ../PuriskiriCategoriasAdm.php?error_duplicado=1");
    die();
}

// Procesar nueva imagen si se subio
$nueva_imagen = '';
$imagen_a_eliminar = '';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $archivo = $_FILES['imagen'];
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    // Validar tipo de archivo
    if (!in_array($archivo['type'], $tipos_permitidos)) {
        header("Location: ../PuriskiriCategoriasAdm.php?error=1&msg=tipo_archivo");
        die();
    }

    // Validar tamaño
    if ($archivo['size'] > $max_size) {
        header("Location: ../PuriskiriCategoriasAdm.php?error=1&msg=tamaño");
        die();
    }

    // Crear directorio si no existe
    $directorio = '../PURISKIRI/categorias/';
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    // Generar nombre unico
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombre_archivo = $slug . '_' . time() . '.' . $extension;
    $ruta_destino = $directorio . $nombre_archivo;

    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
        $nueva_imagen = 'PURISKIRI/categorias/' . $nombre_archivo;
        // Marcar imagen anterior para eliminar
        if (!empty($categoria_actual['imagen'])) {
            $imagen_a_eliminar = $categoria_actual['imagen'];
        }
    }
}

// Determinar la imagen final
$imagen_final = !empty($nueva_imagen) ? $nueva_imagen : $categoria_actual['imagen'];
$imagen_final_escaped = mysqli_real_escape_string($conexion, $imagen_final);

// Actualizar categoria
$query = "UPDATE puriskiri_categorias
    SET nombre = '$nombre',
        slug = '$slug',
        descripcion = '$descripcion',
        orden = $orden,
        imagen = '$imagen_final_escaped'
    WHERE id = $id";

if (mysqli_query($conexion, $query)) {
    // Si se actualizo correctamente y hay imagen anterior para eliminar
    if (!empty($imagen_a_eliminar) && file_exists('../' . $imagen_a_eliminar)) {
        unlink('../' . $imagen_a_eliminar);
    }
    header("Location: ../PuriskiriCategoriasAdm.php?editada=1");
} else {
    // Si falla el update y se subio nueva imagen, eliminarla
    if (!empty($nueva_imagen) && file_exists('../' . $nueva_imagen)) {
        unlink('../' . $nueva_imagen);
    }
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
}

mysqli_close($conexion);
?>
