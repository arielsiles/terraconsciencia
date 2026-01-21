<?php
include 'conexionBe.php';
$query = "SELECT * FROM usuarios ORDER BY puntos DESC LIMIT 10";
$result = mysqli_query($conexion, $query);
$tableContent = '';
$rank = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $rutaImagen = str_replace('../', './', $row['perfil']);
    $rowContent = "
        <div class='win' style='order: {$rank};'>
            <div class='f1'><div class='num'>{$rank}</div></div>
            <div class='f2'><div class='perfil'>
                <img src='{$rutaImagen}' width='100%' height='100%'>
            </div></div>
            <div class='f3'><div class='nom' style='color:black'>
                {$row['nombre_usuario']}
            </div></div>
            <div class='f4'><div class='puntos'>
                {$row['puntos']}
            </div></div>
        </div>
    ";
    $tableContent .= $rowContent;
    $rank++;
}
echo $tableContent;