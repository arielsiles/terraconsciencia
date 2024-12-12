<?php
    include './PHP/conexionBe.php';
    $sql = "SELECT pregunta, opc1, opc2, opc3 FROM test";
    $resultado = $conexion -> query($sql);
    $pregunta = array();
    $opc1 = array();
    $opc2 = array();
    $opc3 = array();
    while ($row = $resultado -> fetch_assoc()){
        $pregunta[] = $row["pregunta"];
        $opc1[] = $row["opc1"];
        $opc2[] = $row["opc2"];
        $opc3[] = $row["opc3"];
    }
?>