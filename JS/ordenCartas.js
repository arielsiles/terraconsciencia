function mezclarOrden() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./PHP/ordenCartas.php");
  xhr.send();
}
