<?php
include "conexionBe.php";

// Verificar conexión
if (!$conexion) {
    die(json_encode(["error" => "Error de conexión a la base de datos."]));
}

// Obtener respuestas correctas
$query = "SELECT id, fov FROM falsoverdadero WHERE id IN (1, 2, 3, 4, 5)";
$result = mysqli_query($conexion, $query);

$respuestas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $respuestas["a" . $row['id']] = $row['fov'];
}

header("Content-Type: application/json");
echo json_encode($respuestas);

// Cerrar conexión
mysqli_close($conexion);
?>
