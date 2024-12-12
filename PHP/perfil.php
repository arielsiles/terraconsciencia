<?php
    $idUser = $_SESSION['id'];
    $sql = "SELECT id, nombres, apellidos, nacimiento, descripcion FROM perfil WHERE id = '$idUser'";
    $resultado = $conexion -> query($sql);
    $row2 = $resultado -> fetch_assoc();
?>