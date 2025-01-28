<style>
    .about-section {
        padding: 4rem 0;
    }

    .about-image {
        max-width: 100%; /* Asegura que la imagen ocupe todo el ancho disponible */
        height: auto; /* Mantiene las proporciones de la imagen */
        display: block;
        margin: 0 auto; /* Centra la imagen horizontalmente */
    }

    .custom-text-block {
        padding: 2rem;
        text-align: center; /* Centrado en pantallas pequeñas */
    }

    .section-title {
        font-size: 1.8rem; /* Tamaño equilibrado para el título */
        line-height: 1.5; /* Mejor espacio entre líneas */
        font-weight: 700;
    }

    .section-title .highlight {
        color: #5bc1ac; /* Destacar una parte del texto con color */
    }

    .text-muted {
        font-size: 1rem; /* Tamaño de texto menor para párrafos */
        line-height: 1.6; /* Aumentar legibilidad */
    }

    @media (min-width: 768px) {
        .custom-text-block {
            text-align: start; /* Alineación a la izquierda en pantallas medianas y grandes */
        }

        .section-title {
            font-size: 2rem; /* Ajusta el título para pantallas más grandes */
        }
    }

</style>
<section class="about-section section-padding">
    <div class="container">
        <div class="row align-items-center">

            <!-- Imagen al lado izquierdo -->
            <div class="col-lg-6 col-md-5 col-12">
                <img src="IMG/Ilustracionessolopersonaje-05.svg" class="about-image img-fluid" alt="Ilustración">
            </div>

            <!-- Texto al lado derecho -->
            <div class="col-lg-6 col-md-7 col-12">
                <div class="custom-text-block">
                    <h2 class="section-title mb-3 text-center text-md-start">
                        Desde ahora empieza el cambio <br />
                        <span class="highlight">desde tu conocimiento a la acción</span> <br />
                        ¡Prepárate!
                    </h2>
                    <p class="text-muted text-center text-md-start">
                        <strong>La calculadora de Huella Hídrica</strong> es una herramienta que permite cuantificar el uso directo e indirecto del agua en las actividades y evaluar su impacto.
                    </p>
                    <p>¡Descúbrelo ahora!</p>
                    <div class="col-12">
                        <a href="CalculadoraInicio.html" class="custom-btn btn smoothscroll">Haz click para empezar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>