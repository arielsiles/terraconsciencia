<?php
/**
 * API para obtener palabras clave existentes en PURISKIRI
 * Usado para autocompletado en el formulario de subida
 */
session_start();
include "conexionBe.php";

header('Content-Type: application/json');

// Obtener el término de búsqueda
$buscar = isset($_GET['q']) ? mysqli_real_escape_string($conexion, trim($_GET['q'])) : '';

// Obtener todas las palabras clave únicas de los recursos existentes
$query = "SELECT DISTINCT palabras_clave FROM puriskiri_recursos WHERE palabras_clave != '' AND activo = 1";
$resultado = mysqli_query($conexion, $query);

$todas_palabras = [];

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        // Cada recurso puede tener múltiples palabras separadas por comas
        $palabras = explode(',', $row['palabras_clave']);
        foreach ($palabras as $palabra) {
            $palabra = trim(strtolower($palabra));
            if (!empty($palabra) && !in_array($palabra, $todas_palabras)) {
                $todas_palabras[] = $palabra;
            }
        }
    }
}

// Ordenar alfabéticamente
sort($todas_palabras);

// Si hay término de búsqueda, filtrar
if (!empty($buscar)) {
    $buscar_lower = strtolower($buscar);
    $todas_palabras = array_filter($todas_palabras, function($palabra) use ($buscar_lower) {
        return strpos($palabra, $buscar_lower) !== false;
    });
    $todas_palabras = array_values($todas_palabras); // Reindexar
}

// Limitar resultados
$todas_palabras = array_slice($todas_palabras, 0, 20);

// Formatear para Tagify (requiere array de objetos con propiedad 'value')
$sugerencias = array_map(function($palabra) {
    return ['value' => ucfirst($palabra)];
}, $todas_palabras);

echo json_encode($sugerencias);
?>
