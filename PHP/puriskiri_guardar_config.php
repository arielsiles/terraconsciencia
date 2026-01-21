<?php
/**
 * API para guardar configuración de PURISKIRI
 * Solo accesible para Administradores
 */
session_start();
include "conexionBe.php";

header('Content-Type: application/json');

// Verificar permisos - Solo Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
    echo json_encode([
        'success' => false,
        'error' => 'No tienes permisos para modificar la configuración.'
    ]);
    die();
}

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido.'
    ]);
    die();
}

// Obtener datos
$clave = isset($_POST['clave']) ? mysqli_real_escape_string($conexion, trim($_POST['clave'])) : '';
$valor = isset($_POST['valor']) ? mysqli_real_escape_string($conexion, trim($_POST['valor'])) : '';

// Validaciones
if (empty($clave)) {
    echo json_encode([
        'success' => false,
        'error' => 'La clave de configuración es requerida.'
    ]);
    die();
}

// Validaciones específicas por clave
if ($clave === 'limite_archivo_mb') {
    $valor_num = (int)$valor;

    // Validar rango (mínimo 1 MB, máximo 150 MB - límite del servidor)
    if ($valor_num < 1 || $valor_num > 150) {
        echo json_encode([
            'success' => false,
            'error' => 'El límite de archivo debe estar entre 1 y 150 MB.'
        ]);
        die();
    }

    $valor = (string)$valor_num;
}

// Insertar o actualizar
$query = "INSERT INTO puriskiri_config (clave, valor, descripcion)
          VALUES ('$clave', '$valor', '')
          ON DUPLICATE KEY UPDATE valor = '$valor', fecha_modificacion = NOW()";

if (mysqli_query($conexion, $query)) {
    echo json_encode([
        'success' => true,
        'mensaje' => 'Configuración guardada correctamente.',
        'clave' => $clave,
        'valor' => $valor
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Error al guardar la configuración: ' . mysqli_error($conexion)
    ]);
}
?>
