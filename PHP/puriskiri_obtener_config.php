<?php
/**
 * API para obtener configuración de PURISKIRI
 * Retorna JSON con la configuración actual
 */
session_start();
include "conexionBe.php";

header('Content-Type: application/json');

// Obtener una configuración específica o todas
$clave = isset($_GET['clave']) ? mysqli_real_escape_string($conexion, $_GET['clave']) : '';

if (!empty($clave)) {
    // Obtener valor específico
    $query = "SELECT valor FROM puriskiri_config WHERE clave = '$clave'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        echo json_encode([
            'success' => true,
            'clave' => $clave,
            'valor' => $row['valor']
        ]);
    } else {
        // Valores por defecto si no existe en BD
        $defaults = [
            'limite_archivo_mb' => '100'
        ];

        $valor = isset($defaults[$clave]) ? $defaults[$clave] : null;
        echo json_encode([
            'success' => $valor !== null,
            'clave' => $clave,
            'valor' => $valor,
            'default' => true
        ]);
    }
} else {
    // Obtener todas las configuraciones
    $query = "SELECT clave, valor, descripcion FROM puriskiri_config";
    $resultado = mysqli_query($conexion, $query);

    $config = [];
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $config[$row['clave']] = [
                'valor' => $row['valor'],
                'descripcion' => $row['descripcion']
            ];
        }
    }

    // Agregar defaults si no existen
    if (!isset($config['limite_archivo_mb'])) {
        $config['limite_archivo_mb'] = [
            'valor' => '100',
            'descripcion' => 'Tamaño máximo de archivo en MB',
            'default' => true
        ];
    }

    echo json_encode([
        'success' => true,
        'config' => $config
    ]);
}
?>
