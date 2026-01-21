<?php
header('Content-Type: application/json');
include "conexionBe.php";

$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';
$categoria = isset($_GET['categoria']) ? mysqli_real_escape_string($conexion, $_GET['categoria']) : '';
$nivel = isset($_GET['nivel']) ? mysqli_real_escape_string($conexion, $_GET['nivel']) : '';
$tipo = isset($_GET['tipo']) ? mysqli_real_escape_string($conexion, $_GET['tipo']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = isset($_GET['limite']) ? (int)$_GET['limite'] : 12;
$offset = ($pagina - 1) * $por_pagina;

$where = "r.activo = 1";

if (!empty($buscar)) {
    $where .= " AND (r.titulo LIKE '%$buscar%' OR r.descripcion LIKE '%$buscar%' OR r.palabras_clave LIKE '%$buscar%')";
}
if (!empty($categoria)) {
    $where .= " AND c.slug = '$categoria'";
}
if (!empty($nivel)) {
    $where .= " AND n.slug = '$nivel'";
}
if (!empty($tipo)) {
    $where .= " AND r.tipo_archivo = '$tipo'";
}

$query = "SELECT r.*, c.nombre as categoria_nombre, c.slug as categoria_slug, n.nombre as nivel_nombre
    FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE $where
    ORDER BY r.fecha_creacion DESC
    LIMIT $offset, $por_pagina";

$resultado = mysqli_query($conexion, $query);

$recursos = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $recursos[] = $row;
}

// Contar total
$query_count = "SELECT COUNT(*) as total FROM puriskiri_recursos r
    INNER JOIN puriskiri_categorias c ON r.categoria_id = c.id
    INNER JOIN puriskiri_niveles n ON r.nivel_id = n.id
    WHERE $where";
$resultado_count = mysqli_query($conexion, $query_count);
$total = mysqli_fetch_assoc($resultado_count)['total'];

echo json_encode([
    'success' => true,
    'recursos' => $recursos,
    'total' => $total,
    'pagina' => $pagina,
    'por_pagina' => $por_pagina,
    'total_paginas' => ceil($total / $por_pagina)
]);
?>
