<?php
include "PHP/conexionBe.php";
$result = $conexion->query("SELECT dir_imagen, descripcion_pb, dir_pdf FROM seccionpb1");

$resultados = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc())
        $resultados[] = $row; // Almacena cada fila como un arreglo asociativo
}
// Configuración del carrusel
$itemsPorPagina = 4; // Cantidad de cards por página
$totalItems = count($resultados);
$totalPaginas = ceil($totalItems / $itemsPorPagina);
?>

<h4 class="text-center mb-4">Seguridad hídrica y alimentaria para estudiantes</h4>
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="false">
    <div class="carousel-inner">
        <?php
        for ($pagina = 0; $pagina < $totalPaginas; $pagina++) {
            $inicio = $pagina * $itemsPorPagina;
            $fin = min($inicio + $itemsPorPagina, $totalItems);
            $activeClass = ($pagina === 0) ? 'active' : '';
            ?>
            <div class="carousel-item <?= $activeClass ?>">
                <div class="row g-3">
                    <?php
                    for ($i = $inicio; $i < $fin; $i++) {
                        $item = $resultados[$i];
                        $imagen = htmlspecialchars($item['dir_imagen']);
                        $imagen = str_replace('../', './', $imagen);

                        $descripcion = htmlspecialchars($item['descripcion_pb']);
                        $pdf = htmlspecialchars($item['dir_pdf']);
                        ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card" style="background-image: url('<?= $imagen ?>');">
                                <a href="<?= $pdf ?>" class="download-btn" download title="Descargar PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="card-body">
                                    <p class="card-text"><?= $descripcion ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>