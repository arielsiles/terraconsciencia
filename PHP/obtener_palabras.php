<?php
include "conexionBe.php";
$resultado = $conexion->query('SELECT palabras FROM mezcla');
$palabras = array();
while ($fila = $resultado->fetch_assoc()) {
    $palabras[] = $fila['palabras'];
}
header('Content-Type: application/json');
echo json_encode($palabras);
?>