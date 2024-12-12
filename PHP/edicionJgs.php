<?php
    include "conexionBe.php";
    if (!empty($_POST['pregunta1']) && isset($_POST['opc1']) && isset($_POST['opc2']) && isset($_POST['opc3'])&& isset($_POST['opcV1'])) {
        $pregunta1 = $_POST['pregunta1'];
        $opc1 = $_POST['opc1'];
        $opc2 = $_POST['opc2'];
        $opc3 = $_POST['opc3'];
        $opcV1 = $_POST['opcV1'];
        $sql = "UPDATE test SET pregunta = '$pregunta1', opc1 = '$opc1', opc2 = '$opc2', opc3 = '$opc3', opcV = '$opcV1' WHERE id = 1";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta2']) && isset($_POST['opc4']) && isset($_POST['opc5']) && isset($_POST['opc6'])&& isset($_POST['opcV2'])){
        $pregunta2 = $_POST['pregunta2'];
        $opc4 = $_POST['opc4'];
        $opc5 = $_POST['opc5'];
        $opc6 = $_POST['opc6'];
        $opcV2 = $_POST['opcV2'];
        $sql = "UPDATE test SET pregunta = '$pregunta2', opc1 = '$opc4', opc2 = '$opc5', opc3 = '$opc6', opcV = '$opcV2' WHERE id = 2";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta3']) && isset($_POST['opc7']) && isset($_POST['opc8']) && isset($_POST['opc9'])&& isset($_POST['opcV3'])){
        $pregunta3 = $_POST['pregunta3'];
        $opc7 = $_POST['opc7'];
        $opc8 = $_POST['opc8'];
        $opc9 = $_POST['opc9'];
        $opcV3 = $_POST['opcV3'];
        $sql = "UPDATE test SET pregunta = '$pregunta3', opc1 = '$opc7', opc2 = '$opc8', opc3 = '$opc9', opcV = '$opcV3' WHERE id = 3";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta4']) && isset($_POST['opc10']) && isset($_POST['opc11']) && isset($_POST['opc12'])&& isset($_POST['opcV4'])){
        $pregunta4 = $_POST['pregunta4'];
        $opc10 = $_POST['opc10'];
        $opc11 = $_POST['opc11'];
        $opc12 = $_POST['opc12'];
        $opcV4 = $_POST['opcV4'];
        $sql = "UPDATE test SET pregunta = '$pregunta4', opc1 = '$opc10', opc2 = '$opc11', opc3 = '$opc12', opcV = '$opcV4' WHERE id = 4";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta5']) && isset($_POST['opc13']) && isset($_POST['opc14']) && isset($_POST['opc15'])&& isset($_POST['opcV5'])){
        $pregunta5 = $_POST['pregunta5'];
        $opc13 = $_POST['opc13'];
        $opc14 = $_POST['opc14'];
        $opc15 = $_POST['opc15'];
        $opcV5 = $_POST['opcV5'];
        $sql = "UPDATE test SET pregunta = '$pregunta5', opc1 = '$opc13', opc2 = '$opc14', opc3 = '$opc15', opcV = '$opcV5' WHERE id = 5";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 

    }
    if (!empty($_POST['pregunta6']) && isset($_POST['opc16']) && isset($_POST['opc17']) && isset($_POST['opc18'])&& isset($_POST['opcV6'])){
        $pregunta6 = $_POST['pregunta6'];
        $opc16 = $_POST['opc16'];
        $opc17 = $_POST['opc17'];
        $opc18 = $_POST['opc18'];
        $opcV6 = $_POST['opcV6'];
        $sql = "UPDATE test SET pregunta = '$pregunta6', opc1 = '$opc16', opc2 = '$opc17', opc3 = '$opc18', opcV = '$opcV6' WHERE id = 6";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta7']) && isset($_POST['opc19']) && isset($_POST['opc20']) && isset($_POST['opc21'])&& isset($_POST['opcV7'])){
        $pregunta7 = $_POST['pregunta7'];
        $opc19 = $_POST['opc19'];
        $opc20 = $_POST['opc20'];
        $opc21 = $_POST['opc21'];
        $opcV7 = $_POST['opcV7'];
        $sql = "UPDATE test SET pregunta = '$pregunta7', opc1 = '$opc19', opc2 = '$opc20', opc3 = '$opc21', opcV = '$opcV7' WHERE id = 7";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta8']) && isset($_POST['opc22']) && isset($_POST['opc23']) && isset($_POST['opc24'])&& isset($_POST['opcV8'])){
        $pregunta8 = $_POST['pregunta8'];
        $opc22 = $_POST['opc22'];
        $opc23 = $_POST['opc23'];
        $opc24 = $_POST['opc24'];
        $opcV8 = $_POST['opcV8'];
        $sql = "UPDATE test SET pregunta = '$pregunta8', opc1 = '$opc22', opc2 = '$opc23', opc3 = '$opc24', opcV = '$opcV8' WHERE id = 8";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta9']) && isset($_POST['opc25']) && isset($_POST['opc26']) && isset($_POST['opc27'])&& isset($_POST['opcV9'])){
        $pregunta9 = $_POST['pregunta9'];
        $opc25 = $_POST['opc25'];
        $opc26 = $_POST['opc26'];
        $opc27 = $_POST['opc27'];
        $opcV9 = $_POST['opcV9'];
        $sql = "UPDATE test SET pregunta = '$pregunta9', opc1 = '$opc25', opc2 = '$opc26', opc3 = '$opc27', opcV = '$opcV9' WHERE id = 9";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
    if (!empty($_POST['pregunta10']) && isset($_POST['opc28']) && isset($_POST['opc29']) && isset($_POST['opc30'])&& isset($_POST['opcV10'])){
        $pregunta10 = $_POST['pregunta10'];
        $opc28 = $_POST['opc28'];
        $opc29 = $_POST['opc29'];
        $opc30 = $_POST['opc30'];
        $opcV10 = $_POST['opcV10'];
        $sql = "UPDATE test SET pregunta = '$pregunta10', opc1 = '$opc28', opc2 = '$opc29', opc3 = '$opc30', opcV = '$opcV10' WHERE id = 10";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            header("Location: ../J2.php");
        } 
    }
?>