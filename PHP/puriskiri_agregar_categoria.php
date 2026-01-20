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
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre'] ?? ''));
$slug = mysqli_real_escape_string($conexion, trim($_POST['slug'] ?? ''));
$descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
$orden = (int)($_POST['orden'] ?? 0);

// Validar datos requeridos
if (empty($nombre) || empty($slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Validar formato del slug (solo minusculas, numeros y guiones)
if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Verificar que no exista una categoria con el mismo nombre o slug
$query_check = "SELECT id FROM puriskiri_categorias WHERE nombre = '$nombre' OR slug = '$slug'";
$resultado_check = mysqli_query($conexion, $query_check);

if (mysqli_num_rows($resultado_check) > 0) {
    header("Location: ../PuriskiriCategoriasAdm.php?error_duplicado=1");
    die();
}

// Procesar imagen si se subio
$ruta_imagen = '';
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
        $ruta_imagen = 'PURISKIRI/categorias/' . $nombre_archivo;
    }
}

// Insertar nueva categoria
$ruta_imagen_escaped = mysqli_real_escape_string($conexion, $ruta_imagen);
$query = "INSERT INTO puriskiri_categorias (nombre, slug, descripcion, orden, imagen, activo)
    VALUES ('$nombre', '$slug', '$descripcion', $orden, '$ruta_imagen_escaped', 1)";

if (mysqli_query($conexion, $query)) {
    header("Location: ../PuriskiriCategoriasAdm.php?agregada=1");
} else {
    // Si falla el insert y se subio imagen, eliminarla
    if (!empty($ruta_imagen) && file_exists('../' . $ruta_imagen)) {
        unlink('../' . $ruta_imagen);
    }
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
}

mysqli_close($conexion);
?>
