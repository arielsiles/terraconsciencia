<?php
header('Content-Type: application/json');
include "conexionBe.php";

$query = "SELECT c.*,
    (SELECT COUNT(*) FROM puriskiri_recursos r WHERE r.categoria_id = c.id AND r.activo = 1) as total_recursos
    FROM puriskiri_categorias c
    WHERE c.activo = 1
    ORDER BY c.orden";

$resultado = mysqli_query($conexion, $query);

$categorias = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $categorias[] = $row;
}

echo json_encode([
    'success' => true,
    'categorias' => $categorias
]);
?>
