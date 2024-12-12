<?php
    include_once "conexionBe.php";
    include_once "functions.php";
    $section = $_GET["section"];
    $data = getData($section);
    echo json_encode($data);
?>
