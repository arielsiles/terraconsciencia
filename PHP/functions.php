<?php
include_once "conexionBe.php";
function getData($section) {
  global $conexion;
  $sql = "SELECT * FROM " . $section;
  $result = mysqli_query($conexion, $sql);
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
      "src" => $row["dir_imagen"],
      "description" => $row["descripcion_pb"],
      "pdf_url" => $row["dir_pdf"] 
    );
  }
  return $data;
}
?>