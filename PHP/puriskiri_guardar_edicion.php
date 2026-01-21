<?php
session_start();
include "conexionBe.php";

// Verificar permisos
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ../Puriskiri.php");
    die();
}

// Verificar que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../PuriskiriDescargar.php");
    die();
}

// Obtener ID del recurso
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    header("Location: ../PuriskiriDescargar.php?error=1");
    die();
}

// Verificar que el recurso existe
$query = "SELECT * FROM puriskiri_recursos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: ../PuriskiriDescargar.php?error=2");
    die();
}

$recurso = mysqli_fetch_assoc($resultado);

// Verificar permisos de edición
if ($_SESSION['rol'] != 'Administrador' && $recurso['usuario_id'] != $_SESSION['id']) {
    header("Location: ../PuriskiriDetalle.php?id=$id&error=permisos");
    die();
}

// Obtener datos del formulario
$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($conexion, trim($_POST['titulo'])) : '';
$descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($conexion, trim($_POST['descripcion'])) : '';
$categoria_id = isset($_POST['categoria']) ? (int)$_POST['categoria'] : 0;
$nivel_id = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 0;
$autor = isset($_POST['autor']) ? mysqli_real_escape_string($conexion, trim($_POST['autor'])) : '';
$palabras_clave = isset($_POST['palabras_clave']) ? mysqli_real_escape_string($conexion, trim($_POST['palabras_clave'])) : '';
$destacado = isset($_POST['destacado']) && $_SESSION['rol'] == 'Administrador' ? 1 : $recurso['destacado'];

// Validaciones básicas
if (empty($titulo) || empty($descripcion) || $categoria_id <= 0 || $nivel_id <= 0) {
    header("Location: ../PuriskiriEditar.php?id=$id&error=campos");
    die();
}

// Inicializar variables para archivos
$ruta_archivo = $recurso['ruta_archivo'];
$tipo_archivo = $recurso['tipo_archivo'];
$ruta_portada = $recurso['ruta_portada'];

// Procesar nuevo archivo (si se subió)
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $extensiones_permitidas = ['pdf', 'ppt', 'pptx', 'doc', 'docx', 'xlsx'];
    $archivo_nombre = $_FILES['archivo']['name'];
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $archivo_extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));

    if (in_array($archivo_extension, $extensiones_permitidas) && $_FILES['archivo']['size'] <= 50 * 1024 * 1024) {
        $timestamp = date('Ymd_His');
        $unique_id = uniqid();
        $nuevo_nombre_archivo = $timestamp . '_' . $unique_id . '.' . $archivo_extension;
        $ruta_destino = "../PURISKIRI/documentos/" . $nuevo_nombre_archivo;
        $nueva_ruta_bd = "PURISKIRI/documentos/" . $nuevo_nombre_archivo;

        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            // Eliminar archivo anterior
            $archivo_anterior = "../" . $recurso['ruta_archivo'];
            if (file_exists($archivo_anterior)) {
                unlink($archivo_anterior);
            }

            $ruta_archivo = $nueva_ruta_bd;
            $tipo_archivo = $archivo_extension;
        }
    }
}

// Procesar nueva portada (si se subió)
if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
    $extensiones_imagen = ['jpg', 'jpeg', 'png', 'gif'];
    $portada_nombre = $_FILES['portada']['name'];
    $portada_tmp = $_FILES['portada']['tmp_name'];
    $portada_extension = strtolower(pathinfo($portada_nombre, PATHINFO_EXTENSION));

    if (in_array($portada_extension, $extensiones_imagen) && $_FILES['portada']['size'] <= 5 * 1024 * 1024) {
        $timestamp = date('Ymd_His');
        $unique_id = uniqid();
        $nuevo_nombre_portada = $timestamp . '_' . $unique_id . '_portada.' . $portada_extension;
        $ruta_portada_destino = "../PURISKIRI/portadas/" . $nuevo_nombre_portada;
        $nueva_ruta_portada_bd = "PURISKIRI/portadas/" . $nuevo_nombre_portada;

        if (move_uploaded_file($portada_tmp, $ruta_portada_destino)) {
            // Eliminar portada anterior si existe
            if (!empty($recurso['ruta_portada'])) {
                $portada_anterior = "../" . $recurso['ruta_portada'];
                if (file_exists($portada_anterior)) {
                    unlink($portada_anterior);
                }
            }

            $ruta_portada = $nueva_ruta_portada_bd;
        }
    }
}

// Actualizar en base de datos
$query_update = "UPDATE puriskiri_recursos SET
    titulo = '$titulo',
    descripcion = '$descripcion',
    categoria_id = $categoria_id,
    nivel_id = $nivel_id,
    tipo_archivo = '$tipo_archivo',
    ruta_archivo = '$ruta_archivo',
    ruta_portada = '$ruta_portada',
    autor = '$autor',
    palabras_clave = '$palabras_clave',
    destacado = $destacado
    WHERE id = $id";

if (mysqli_query($conexion, $query_update)) {
    header("Location: ../PuriskiriEditar.php?id=$id&exito=1");
} else {
    header("Location: ../PuriskiriEditar.php?id=$id&error=db");
}
?>
