<?php
include "conexionBe.php";

// Verificar conexión
if (!$conexion) {
    die(json_encode(["error" => "Error de conexión a la base de datos."]));
}

// Obtener preguntas
$query = "SELECT id, pregunta FROM falsoverdadero WHERE id IN (1, 2, 3, 4, 5)";
$result = mysqli_query($conexion, $query);

$preguntas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $preguntas[] = $row;
}

header("Content-Type: application/json");
echo json_encode($preguntas);

// Cerrar conexión
mysqli_close($conexion);
?>
