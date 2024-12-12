<?php
include 'PHP/conexionBe.php';

$rutas = [];

for ($id = 1; $id <= 12; $id++) {
    $sql = "SELECT ruta FROM img_ord WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        // Verifica si la consulta devolvió resultados
        $row = $resultado->fetch_assoc();

        if ($row) {
            // Verifica si se obtuvo un resultado válido
            $rutaImagen = str_replace('../', './', $row['ruta']);
            $rutas[] = $rutaImagen;
        } else {
            // Maneja el caso en que no se encontró la imagen para el ID actual
            $rutas[] = 'RUTA_NO_ENCONTRADA';
        }
    } else {
        // Maneja el caso de un error en la consulta
        $rutas[] = 'ERROR_CONSULTA';
    }
}

// Ahora $rutas contiene las rutas de las imágenes o indicadores de error si algo salió mal
?>

