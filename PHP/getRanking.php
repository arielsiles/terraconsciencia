<?php
include 'conexionBe.php';
$query = "SELECT * FROM usuarios ORDER BY puntos DESC LIMIT 10";
$result = mysqli_query($conexion, $query);
$tableContent = '';
$rank = 1;

$tableContent = "
<table class='table table-bordered table-striped align-middle mb-0 w-100'>
    <thead>
    <tr>
        <th class='text-center' style='width: 5%;'>#</th>
        <th style='width: 15%;'>Perfil</th>
        <th style='width: 65%;'>Nombre</th>
        <th class='text-center' style='width: 15%;'>Pts</th>
    </tr>
    </thead>
    <tbody>
";

while ($row = mysqli_fetch_assoc($result)) {
    $rutaImagen = str_replace('../', './', $row['perfil']);
    $rowContent = "<tr>
	                    <td class='text-center'>
                            <span class='badge custom-badge'>{$rank}</span>
                        </td>
                        <td>
                            <img src='{$rutaImagen}' class='img-fluid avatar-image rounded-circle' alt='' style='width: 40px; height: 40px;'>
                        </td>
                        <td>
                            {$row['nombre_usuario']}
                        </td>
                        <td class='text-center'>
                            <span class='badge text-bg-danger'>{$row['puntos']}</span>
                        </td>
                    </tr>";
    $tableContent .= $rowContent;
    $rank++;
}

$tableContent .= "
    </tbody>
</table>
";
echo $tableContent;